<?php


namespace common\lib;


use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;

class ViewRemaster extends View{

    public $html;

    public function registerCustomHtml($html, $position = self::POS_READY, $key = null)
    {
        $key = $key ?: md5($html);
        $this->html[$position][$key] = $html;
    }

    /**
     * Registers a CSS file.
     *
     * This method should be used for simple registration of CSS files. If you want to use features of
     * [[AssetManager]] like appending timestamps to the URL and file publishing options, use [[AssetBundle]]
     * and [[registerAssetBundle()]] instead.
     *
     * @param string $url the CSS file to be registered.
     * @param array $options the HTML attributes for the link tag. Please refer to [[Html::cssFile()]] for
     * the supported options. The following options are specially handled and are not treated as HTML attributes:
     *
     * - `depends`: array, specifies the names of the asset bundles that this CSS file depends on.
     * - `appendTimestamp`: bool whether to append a timestamp to the URL.
     *
     * @param string $key the key that identifies the CSS script file. If null, it will use
     * $url as the key. If two CSS files are registered with the same key, the latter
     * will overwrite the former.
     * @throws InvalidConfigException
     */
    public function registerCssFile($url, $options = [], $key = null)
    {
        $this->registerFile('css', $url, $options, $key);
    }

    /**
     * Registers a JS or CSS file.
     *
     * @param string $url the JS file to be registered.
     * @param string $type type (js or css) of the file.
     * @param array $options the HTML attributes for the script tag. The following options are specially handled
     * and are not treated as HTML attributes:
     *
     * - `depends`: array, specifies the names of the asset bundles that this CSS file depends on.
     * - `appendTimestamp`: bool whether to append a timestamp to the URL.
     *
     * @param string $key the key that identifies the JS script file. If null, it will use
     * $url as the key. If two JS files are registered with the same key at the same position, the latter
     * will overwrite the former. Note that position option takes precedence, thus files registered with the same key,
     * but different position option will not override each other.
     * @throws InvalidConfigException
     */
    private function registerFile($type, $url, $options = [], $key = null)
    {
//        debug($options);
        $url = Yii::getAlias($url);
        $key = $key ?: $url;
        $depends = ArrayHelper::remove($options, 'depends', []);
        $position = ArrayHelper::remove($options, 'position', self::POS_END);

        try {
            $asssetManagerAppendTimestamp = $this->getAssetManager()->appendTimestamp;
        } catch (InvalidConfigException $e) {
            $depends = null; // the AssetManager is not available
            $asssetManagerAppendTimestamp = false;
        }
        $appendTimestamp = ArrayHelper::remove($options, 'appendTimestamp', $asssetManagerAppendTimestamp);

        if (empty($depends)) {
            // register directly without AssetManager
            if ($appendTimestamp && Url::isRelative($url) && ($timestamp = @filemtime(Yii::getAlias('@webroot/' . ltrim($url, '/'), false))) > 0) {
                $url = $timestamp ? "$url?v=$timestamp" : $url;
            }
            if ($type === 'js') {
                $this->jsFiles[$position][$key] = Html::jsFile($url, $options);
            } else {
                $this->cssFiles[$position][$key] = Html::cssFile($url, $options);
            }
        } else {
            $this->getAssetManager()->bundles[$key] = Yii::createObject([
                'class' => AssetBundle::className(),
                'baseUrl' => '',
                'basePath' => '@webroot',
                (string)$type => [!Url::isRelative($url) ? $url : ltrim($url, '/')],
                "{$type}Options" => $options,
                'depends' => (array)$depends,
            ]);
            $this->registerAssetBundle($key);
        }
    }



    /**
     * Renders the content to be inserted in the head section.
     * The content is rendered using the registered meta tags, link tags, CSS/JS code blocks and files.
     * @return string the rendered content
     */
    protected function renderHeadHtml()
    {
//        debug($this);
        $lines = [];
        if (!empty($this->metaTags)) {
            $lines[] = implode("\n", $this->metaTags);
        }

        if (!empty($this->linkTags)) {
            $lines[] = implode("\n", $this->linkTags);
        }
        if (!empty($this->cssFiles[self::POS_HEAD])) {
            $lines[] = implode("\n", $this->cssFiles[self::POS_HEAD]);
        }

//        if (!empty($this->cssFiles)) {
//            $lines[] = implode("\n", $this->cssFiles);
//        }
        if (!empty($this->css)) {
            $lines[] = implode("\n", $this->css);
        }
        if (!empty($this->jsFiles[self::POS_HEAD])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_HEAD]);
        }
        if (!empty($this->js[self::POS_HEAD])) {
            $lines[] = Html::script(implode("\n", $this->js[self::POS_HEAD]));
        }

        if (!empty($this->html[self::POS_HEAD])) {
            $lines[] = implode("\n", $this->html[self::POS_HEAD]);
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

    /**
     * Renders the content to be inserted at the beginning of the body section.
     * The content is rendered using the registered JS code blocks and files.
     * @return string the rendered content
     */
    protected function renderBodyBeginHtml()
    {
        $lines = [];

        if (!empty($this->jsFiles[self::POS_BEGIN])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_BEGIN]);
        }
        if (!empty($this->js[self::POS_BEGIN])) {
            $lines[] = Html::script(implode("\n", $this->js[self::POS_BEGIN]));
        }

        if (!empty($this->html[self::POS_BEGIN])) {
            $lines[] = implode("\n", $this->html[self::POS_BEGIN]);
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

    /**
     * Renders the content to be inserted at the end of the body section.
     * The content is rendered using the registered JS code blocks and files.
     * @param bool $ajaxMode whether the view is rendering in AJAX mode.
     * If true, the JS scripts registered at [[POS_READY]] and [[POS_LOAD]] positions
     * will be rendered at the end of the view like normal scripts.
     * @return string the rendered content
     */
    protected function renderBodyEndHtml($ajaxMode)
    {
        $lines = [];

        if (!empty($this->jsFiles[self::POS_END])) {
            $lines[] = implode("\n", $this->jsFiles[self::POS_END]);
        }
        if (!empty($this->cssFiles[self::POS_END])) {
            $lines[] = implode("\n", $this->cssFiles[self::POS_END]);
        }

//        debug($this->jsFiles);
//        debug($this->cssFiles);
//
//        if (!empty($this->cssFiles)) {
//            $lines[] = implode("\n", $this->cssFiles);
//        }

        if ($ajaxMode) {
            $scripts = [];
            if (!empty($this->js[self::POS_END])) {
                $scripts[] = implode("\n", $this->js[self::POS_END]);
            }
            if (!empty($this->js[self::POS_READY])) {
                $scripts[] = implode("\n", $this->js[self::POS_READY]);
            }
            if (!empty($this->js[self::POS_LOAD])) {
                $scripts[] = implode("\n", $this->js[self::POS_LOAD]);
            }
            if (!empty($scripts)) {
                $lines[] = Html::script(implode("\n", $scripts));
            }
        } else {
            if (!empty($this->js[self::POS_END])) {
                $lines[] = Html::script(implode("\n", $this->js[self::POS_END]));
            }
            if (!empty($this->js[self::POS_READY])) {
                $js = "jQuery(function ($) {\n" . implode("\n", $this->js[self::POS_READY]) . "\n});";
                $lines[] = Html::script($js);
            }
            if (!empty($this->js[self::POS_LOAD])) {
                $js = "jQuery(window).on('load', function () {\n" . implode("\n", $this->js[self::POS_LOAD]) . "\n});";
                $lines[] = Html::script($js);
            }
        }

        return empty($lines) ? '' : implode("\n", $lines);
    }

}