<?php
namespace app\modules\admin\models;


include '/../vendor/phpppt/Classes/PHPPowerpoint/IComparable.php';
include '/../vendor/phpppt/Classes/PHPPowerpoint/IOFactory.php';

class PPTools
{
    public static function getPPT()
    {
        $objPHPPowerPoint = new \PHPPowerPoint();
        return $objPHPPowerPoint;
    }

    public static function createPPT() {
        $objPHPPowerPoint = PPTools::getPPT();

        //设置文件属性
        $objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw");
        $objPHPPowerPoint->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPPowerPoint->getProperties()->setTitle("Office 2007 PPTX Test Document");
        $objPHPPowerPoint->getProperties()->setSubject("Office 2007 PPTX Test Document");
        $objPHPPowerPoint->getProperties()->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.");
        $objPHPPowerPoint->getProperties()->setKeywords("office 2007 openxml php");
        $objPHPPowerPoint->getProperties()->setCategory("Test result file");

        $currentSlide = $objPHPPowerPoint->getActiveSlide();

        //创建左上角Logo
        $shape = $currentSlide->createDrawingShape();
        $shape->setName('PHPPowerPoint logo');
        $shape->setDescription('PHPPowerPoint logo');
        $shape->setPath('C:/Users/ruiqiang/Desktop/logo.gif');
        $shape->setHeight(36);
        $shape->setOffsetX(10);
        $shape->setOffsetY(10);
        $shape->getShadow()->setVisible(true);
        $shape->getShadow()->setDirection(45);
        $shape->getShadow()->setDistance(10);

        //创建富文本区
        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(300);
        $shape->setWidth(600);
        $shape->setOffsetX(170);
        $shape->setOffsetY(180);
        $shape->getAlignment()->setHorizontal( \PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun('Thank you for using PHPPowerPoint!My name is 芮强');
        $textRun->getFont()->setBold(true);
        $textRun->getFont()->setSize(60);
        $textRun->getFont()->setColor( new \PHPPowerPoint_Style_Color('FFC00000') );

        $objWriter = \PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');

        $folder = dirname(dirname(dirname(dirname(__FILE__)))) . '\\ppt';

        $fileName = '\\2.pptx';

        $objWriter->save($folder . $fileName);
    }
}
?>