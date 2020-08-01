<?php
/**
 * Created by PhpStorm.
 * User: tolik
 * Date: 21.12.19
 * Time: 14:11
 */

namespace common\lib\costarico_mod;


use rico\yii2images\behaviors\ImageBehave;
//use rico\yii2images\models\Image;
use Yii;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

class ImageBehaveModifed extends ImageBehave {


    /**
     *
     * Method copies image file to module store and creates db record.
     *
     * метод перероблено дає можливість прикріпити зображення до сутності без завантаження (зображення) потрібно для
     * роботи з файл менеджером
     *
     * @param $absolutePath
     * @param bool $isMain
     * @return bool|Image
     * @throws \Exception
     */
    public function attachImageNotUpload($newAbsolutePath, $isMain = false, $name = '')
    {

        if (!$this->owner->primaryKey) {
            throw new \Exception('Owner must have primaryKey when you attach image!');
        }

//		if ($this->getModule()->className === null) {
//			$image = new ImageModifed();
//		} else {
//			$class = $this->getModule()->className;
//			$image = new $class();
//		}
        $image = new ImageModifed();

//		$fileInfo = pathinfo($newAbsolutePath);
        $image->itemId = $this->owner->primaryKey;

//		$pathArr = explode($this->getModule()->getStorePath().'/',$newAbsolutePath);
        $pathArr = explode('/files/',$newAbsolutePath);
//	    debug($pathArr);die();

//		$image->filePath = '' . $fileInfo['basename'];
        if(!isset($pathArr[1])) return false;
        $image->filePath = '' . $pathArr[1];

        $image->modelName = $this->getModule()->getShortClass($this->owner);
        $image->name = $name;

        $image->urlAlias = $this->getAlias($image);
//		$image->urlAlias = '';
        if(!$image->save()){
            return false;
        }
        $img = $this->owner->getImage();
        //If main image not exists
        if(
            is_object($img) && get_class($img)=='rico\yii2images\models\PlaceHolder'
            or
            $img == null
            or
            $isMain
        ){
            $this->setMainImage($image);
        }

        return $image;
    }

    /**
     * removes concrete model's image
     * @param Image $img
     * @throws \Exception
     * @return bool
     */
    public function removeImageNoDel(ImageModifed $img)
    {
//		if ($img instanceof models\PlaceHolder) {
//			return false;
//		}
        $img->clearCache();

        $storePath = $this->getModule()->getStorePath();

//		$fileToRemove = $storePath . DIRECTORY_SEPARATOR . $img->filePath;
//		if (preg_match('@\.@', $fileToRemove) and is_file($fileToRemove)) {
//			unlink($fileToRemove);
//		}
        $img->delete();
        return true;
    }

    /**
     * returns main model image
     * @return array|null|ActiveRecord
     */
    public function getImage()
    {
//		if ($this->getModule()->className === null) {
//			$imageQuery = ImageModifed::find();
//		} else {
//			$class = $this->getModule()->className;
//			$imageQuery = $class::find();
//		}
        $imageQuery = ImageModifed::find();
        $finder = $this->getImagesFinder(['isMain' => 1]);
        $imageQuery->where($finder);
        $imageQuery->orderBy(['isMain' => SORT_DESC, 'id' => SORT_ASC]);

        $img = $imageQuery->one();
        if(!$img){
            return $this->getModule()->getPlaceHolder();
        }

        return $img;
    }

    /**
     * returns model image by name
     * @return array|null|ActiveRecord
     */
    public function getImageByName($name)
    {
//		if ($this->getModule()->className === null) {
//			$imageQuery = ImageModifed::find();
//		} else {
//			$class = $this->getModule()->className;
//			$imageQuery = $class::find();
//		}
        $imageQuery = ImageModifed::find();
        $finder = $this->getImagesFinder(['name' => $name]);
        $imageQuery->where($finder);
        $imageQuery->orderBy(['isMain' => SORT_DESC, 'id' => SORT_ASC]);

        $img = $imageQuery->one();
//		if(!$img){
//			return $this->getModule()->getPlaceHolder();
//			return false;
//		}
        return $img;
    }
    /**
     * returns model image by name
     * @return array|null|ActiveRecord
     */
    public function getImagesByName($name)
    {
            $imageQuery = ImageModifed::find();
//        if ($this->getModule()->className === null) {
//        } else {
//            $class = $this->getModule()->className;
//            $imageQuery = $class::find();
//        }
        $finder = $this->getImagesFinder(['name' => $name]);
        $imageQuery->where($finder);
        $imageQuery->orderBy(['isMain' => SORT_DESC, 'id' => SORT_ASC]);

        $img = $imageQuery->all();
//		if(!$img){
//			return $this->getModule()->getPlaceHolder();
//			return false;
//		}
        return $img;
    }

    private function getImagesFinder($additionWhere = false)
    {
        $base = [
            'itemId' => $this->owner->primaryKey,
            'modelName' => $this->getModule()->getShortClass($this->owner)
        ];

        if ($additionWhere) {
            $base = \yii\helpers\BaseArrayHelper::merge($base, $additionWhere);
        }

        return $base;
    }


    /** Make string part of image's url
     * @return string
     * @throws \Exception
     */
    private function getAliasString()
    {
        if ($this->createAliasMethod) {
            $string = $this->owner->{$this->createAliasMethod}();
            if (!is_string($string)) {
                throw new \Exception("Image's url must be string!");
            } else {
                return $string;
            }

        } else {
            return substr(md5(microtime()), 0, 10);
        }
    }

    /**
     *
     * Обновить алиасы для картинок
     * Зачистить кэш
     */
    private function getAlias()
    {
        $aliasWords = $this->getAliasString();
        $imagesCount = count($this->owner->getImages());

        return $aliasWords . '-' . intval($imagesCount + 1);
    }

}