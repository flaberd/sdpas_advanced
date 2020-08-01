<?php
/**
 * Created by PhpStorm.
 * User: tolik
 * Date: 21.12.19
 * Time: 15:12
 */

namespace common\lib\costarico_mod;

use abeautifulsite\SimpleImage;
use Imagick;
use rico\yii2images\models\Image;
use Yii;
use yii\base\Exception;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;

class ImageModifed extends Image {

    public function getPathSVG($size = false){
        if($this->getExtension()!='svg'){
            $urlSize = ($size) ? '_'.$size : '';
            $base = $this->getModule()->getCachePath();
            $sub = $this->getSubDur();

            $origin = $this->getPathToOrigin();

            $filePath = $base.DIRECTORY_SEPARATOR.
                $sub.DIRECTORY_SEPARATOR.$this->urlAlias.$urlSize.'.'.pathinfo($origin, PATHINFO_EXTENSION);

            if(!file_exists($filePath)){
                if(!file_exists($origin)){ return ''; }
                $this->createVersion($origin, $size);

                if(!file_exists($filePath)){
                    throw new \Exception('Problem with image creating.');
                }
            }
//            debug(Yii::$app->id);die();
            if(Yii::$app->id=='app-backend'){
                $url = Yii::$app->urlManagerFrontend->createUrl(
                    '/frontend/web/cache/'.$sub.DIRECTORY_SEPARATOR.$this->urlAlias.$urlSize.'.'.pathinfo($origin, PATHINFO_EXTENSION)
                );
            }else{
                $url = '/frontend/web/cache/'.$sub.DIRECTORY_SEPARATOR.$this->urlAlias.$urlSize.'.'.pathinfo($origin, PATHINFO_EXTENSION);
//                $url = Yii::$app->urlManager->createUrl(
//                    '/frontend/web/cache/'.$sub.DIRECTORY_SEPARATOR.$this->urlAlias.$urlSize.'.'.pathinfo($origin, PATHINFO_EXTENSION)
//                );
            }

            return $url;
        }else{
//			debug($this->getSubDur());
            return '/frontend/web/files/'.$this->filePath;
        }


    }

    public function getUrlToOrigin(){
        return '/frontend/web/files/'.$this->filePath;
    }

    public function clearCache(){
        $subDir = $this->getSubDur();

        $dirToRemove = $this->getModule()->getCachePath().DIRECTORY_SEPARATOR.$subDir;

//        if(preg_match('/'.preg_quote($this->modelName, '/').DIRECTORY_SEPARATOR.'/', $dirToRemove)){
        if(preg_match('/'.preg_quote($this->modelName, '/').'/', $dirToRemove)){
            BaseFileHelper::removeDirectory($dirToRemove);

        }

        return true;
    }

    public function getUrlSVG($size = false){
        if($this->getExtension()!='svg'){
            $effectsPart = '';
            if(count($this->effects)>0){
                foreach($this->effects as $effect){
                    $effectsPart .= $effect->getId();
                }
                $effectsPart = '_under'.$effectsPart;
            }
            $urlSize = ($size) ? '_'.$size : '';
            $url = Url::toRoute([
                '/'.$this->getModule()->id.'/images/image-by-item-and-alias',
                'item' => $this->modelName.$this->itemId,
                'dirtyAlias' =>  $this->urlAlias.$effectsPart.$urlSize.'.'.$this->getExtension()
            ]);

            return $url;
        }else{
//			debug($this->getSubDur());
            return '/'.$this->getPathToOrigin();
        }
    }


    public function createversion($imagePath, $sizeString = false, $effects = false)
    {
        if(strlen($this->urlAlias)<1){
            throw new \Exception('Image without urlAlias!');
        }

        $pathToSave = $this->getSavePath($sizeString, $effects);

        BaseFileHelper::createDirectory(dirname($pathToSave), 0777, true);

//debug($sizeString);
        if($sizeString) {
            $size = $this->getModule()->parseSize($sizeString);
        }else{
            $size = false;
        }

//        debug($this->getModule()->graphicsLibrary);
//die();
        if($this->getModule()->graphicsLibrary == 'Imagick'){
            $image = new Imagick($imagePath);
            $image->setImageCompressionQuality($this->getModule()->imageCompressionQuality);

            if($size){
                if($size['height'] && $size['width']){
                    $image->cropThumbnailImage($size['width'], $size['height']);
                }elseif($size['height']){
                    $image->thumbnailImage(0, $size['height']);
                }elseif($size['width']){
                    $image->thumbnailImage($size['width'], 0);
                }else{
                    throw new \Exception('Something wrong with this->module->parseSize($sizeString)');
                }
            }


            /* ---=== WaterMark ===--- */
            if($this->getModule()->waterMark) {

                if(!file_exists(Yii::getAlias($this->getModule()->waterMark))){
                    throw new Exception('WaterMark not detected!');
                }
                $watermark = new Imagick();
                $watermark->readImage(Yii::getAlias($this->getModule()->waterMark));

                $iWidth = $image->getImageWidth();
                $iHeight = $image->getImageHeight();
                $wWidth = $watermark->getImageWidth();
                $wHeight = $watermark->getImageHeight();



                if ($iHeight < $wHeight) {
                    // resize the watermark
                    $watermark->scaleImage(false, $iHeight*0.8);
                }

                if($iWidth < $wWidth) {
                    // resize the watermark
                    $watermark->scaleImage($iWidth*0.8, false);
                }
                $wWidth = $watermark->getImageWidth();
                $wHeight = $watermark->getImageHeight();

                $x = ($iWidth - $wWidth) / 2;
                $y = ($iHeight - $wHeight) / 2;

                $image->compositeImage($watermark, Imagick::COMPOSITE_OVER, $x, $y);
            }


            /* --=== Apply effects ===--- */
            if(count($this->getModule()->effects) >0 && $effects){
                foreach ($this->getModule()->effects as $effect) {
                    $pattern = '/'.preg_quote($effect['id'], '/').'/';
                    if(preg_match($pattern, $effect['id'])){
                        $effect = new $effect['class'];
                        $image = $effect->applyTo($image);
                    }
                }
            }
            $image->writeImage($pathToSave);
        }else{
            if(!file_exists($imagePath)){ return null; }
            $image = new SimpleImage($imagePath);
//            $image = new \abeautifulsite\SimpleImage($imagePath);

//            debug($size);
            if($size){
                if($size['height'] && $size['width']){

                    $image->thumbnail($size['width'], $size['height']);
                }elseif($size['height']){
                    $image->fit_to_height($size['height']);
                }elseif($size['width']){
                    $image->fit_to_width($size['width']);
                }else{
                    throw new \Exception('Something wrong with this->module->parseSize($sizeString)');
                }
            }

            //WaterMark
            if($this->getModule()->waterMark){

                if(!file_exists(Yii::getAlias($this->getModule()->waterMark))){
                    throw new Exception('WaterMark not detected!');
                }

                $wmMaxWidth = intval($image->get_width()*0.4);
                $wmMaxHeight = intval($image->get_height()*0.4);

                $waterMarkPath = Yii::getAlias($this->getModule()->waterMark);

                $waterMark = new \abeautifulsite\SimpleImage($waterMarkPath);



                if(
                    $waterMark->get_height() > $wmMaxHeight
                    or
                    $waterMark->get_width() > $wmMaxWidth
                ){

                    $waterMarkPath = $this->getModule()->getCachePath().DIRECTORY_SEPARATOR.
                        pathinfo($this->getModule()->waterMark)['filename'].
                        $wmMaxWidth.'x'.$wmMaxHeight.'.'.
                        pathinfo($this->getModule()->waterMark)['extension'];

                    //throw new Exception($waterMarkPath);
                    if(!file_exists($waterMarkPath)){
                        $waterMark->fit_to_width($wmMaxWidth);
                        $waterMark->save($waterMarkPath, 100);
                        if(!file_exists($waterMarkPath)){
                            throw new Exception('Cant save watermark to '.$waterMarkPath.'!!!');
                        }
                    }

                }

                $image->overlay($waterMarkPath, 'bottom right', .5, -10, -10);
//
            }
        }

        $image->save($pathToSave, $this->getModule()->imageCompressionQuality);
//        debug('$rr');die();
        return $image;

    }

}