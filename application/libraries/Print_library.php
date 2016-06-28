<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This Class used for create a Table but in Text Model
 * very usesfull when dealing with Dot Matrix Printer
 *
 * @author goblooge
 * @copyright Nurul Huda <goblooge@gmail.com>
 * @since 12 March 2015 23:29
 * @version 1.0.0
 * @license LGPLv3
 *
 */
class Print_library{

    private $width;
    private $column;
    private $border;
    private $line;
    private $columnbase;
    private $header;
    private $footer;
    private $body;
    private $temporer_column;
    private $temporer_content;
    private $temporer_colspan;
    private $temporer_align;
    private $current_column;
    private $initline;
    private $initspace;
    private $is_used_bodyspace;
    private $bodyspace;



    /**
     * initiating TableText
     * $column must less than width
     * $line and $border must <=1 character
     *
     * @param int $width how much text width (100 mean 100 character)
     * @param int $column how much column will be used in this table (5 mean 5 column)
     * @param string $line the line base text to separate header, content and footer. default - <underscore>
     * @param string $border the border base text default | <vertical bar>
     */
    public function __construct($width = 204,$column = 4,$bodyspace=" ",$line="-",$border="|"){
        $this->width=$width;
        $this->column=$column;
        $this->border=$border;
        $this->line=$line;
        $this->header="";
        $this->footer="";
        $this->body="";
        $this->current_column=0;
        $this->initColumnBase($width, $column);
        $this->initLine();
        $this->initSpace();
        $this->temporer_content=array();
        $this->temporer_colspan=array();
        $this->temporer_align=array();
        $this->temporer_column="";
        $this->is_used_bodyspace=false;
        $this->bodyspace=$bodyspace;
    }


    /**
     * set should used the Body Space or NOT
     * @param unknown $used
     */
    public function setUseBodySpace($used){
        $this->is_used_bodyspace=$used;
    }


    /**
     * create line for creating line
     */
    private function initLine(){
        $line=0;
        if(strlen($this->border)>0)	$line=$this->line($this->width+1);
        else $line=$this->line( ($this->width) - ($this->column) );
        $this->initline=$line;
    }
    /**
     * create space for creating space
     */
    private function initSpace(){
        $space=0;
        if(strlen($this->border)==0)	$space="";
        else $space=$this->border.$this->space( ($this->width) - 1).$this->border;
        $this->initspace=$space;
    }

    /**
     * getting length based on colspan
     * @param unknown $colspan
     * @return unknown|number
     */
    public function getLengthBase($colspan){
        if($colspan==1){
            $colbase=$this->columnbase[$this->current_column];
            $this->current_column++;
            return $colbase;
        }else{
            $base=0;
            for($c=0;$c<$colspan;$c++){
                $base+=$this->columnbase[$this->current_column+$c];
            }
            $base+=$colspan-1;
            $this->current_column+=$colspan;
            return $base;
        }
    }

    /**
     * refined content based on lenght and align
     * @param unknown $content
     * @param unknown $length
     * @param unknown $align
     * @return string
     */
    public function refinedContent($content,$length,$align){
        $vlen=strlen($content);
        if($vlen>$length){
            return substr($content, 0,$length);
        }

        if($align=="left") {
            $space=$this->space($length-$vlen);
            return $content.$space;
        }else if($align=="right"){
            $space=$this->space($length-$vlen);
            return $space.$content;
        }else{
            $selisih=$length-$vlen;
            $left=floor($selisih/2);
            $right=$selisih-$left;
            $spaceleft=$this->space($left);
            $spaceright=$this->space($right);
            return $spaceleft.$content.$spaceright;
        }

    }

    /**
     * adding a new Column to Table
     * @param $content the content that want to add
     * @param $colspan how many colspan
     * @param string $align should be center,left, or right
     * @param string $commit put it on the head,body, or footer
     * @return TableText
     */
    public function addColumn($content,$colspan,$align='left',$commit=NULL){
        $this->temporer_content[]=$content;
        $this->temporer_colspan[]=$colspan;
        $this->temporer_align[]=$align;

        if($commit!=NULL){
            $this->commit($commit);
        }
        return $this;
    }

    /**
     * put current temporary_column to the body, footer or header.
     * @param stirng $commit shouild be body, footer or header
     * @return TableText
     */
    public function commit($commit){
        $continue=true;
        while($continue){
            $number=0;
            $continue=false;
            foreach($this->temporer_content as $content){
                $colspan=$this->temporer_colspan[$number];
                $align=$this->temporer_align[$number];
                $ct_in=$this->putColumn($content, $colspan, $align);
                $this->temporer_content[$number]=substr($this->temporer_content[$number], $ct_in);
                if(strlen($this->temporer_content[$number])>0)	$continue=true;
                $number++;
            }
            $this->line_commit($commit);
        }
        $this->addBodySpace($commit);
        $this->temporer_content=array();
        $this->temporer_colspan=array();
        $this->temporer_align=array();
        return $this;
    }

    /**
     * adding new space in Table
     * @param string $commit should be body, footer or header
     */
    private function addBodySpace($commit){
        if($commit=="body" && $this->is_used_bodyspace){
            $number=0;
            foreach($this->temporer_content as $content){
                $colspan=$this->temporer_colspan[$number];
                $align=$this->temporer_align[$number];
                $this->putBodySpace($colspan);
                $number++;
            }
            $this->line_commit($commit);
        }
    }

    /**
     * put the column to header, footer or body
     * @param string $commit it must be header, footer or body
     * @return TableText
     */
    public function line_commit($commit){
        if($commit=="header"){
            $this->header.=$this->temporer_column.$this->border."\n";
        }else if($commit=="body"){
            $this->body.=$this->temporer_column.$this->border."\n";
        }else if($commit=="footer"){
            $this->footer.=$this->temporer_column.$this->border."\n";
        }
        $this->current_column=0;
        $this->temporer_column="";
        return $this;
    }

    /**
     * put content for one column, it's handling more than one
     * line of content.
     * @param string $content the one line content
     * @param int $colspan
     * @param string $align should be center, right or left
     * @return number
     */
    public function putColumn($content,$colspan,$align){
        $lengthbase=$this->getLengthBase($colspan);
        $ct=$this->refinedContent($content, $lengthbase,$align);
        $this->temporer_column.=$this->border.$ct;
        return strlen($ct);
    }

    /**
     * put line/space in to separate beetween a line in the body
     * @param unknown $colspan
     * @return TableText
     */
    public function putBodySpace($colspan){
        $lengthbase=$this->getLengthBase($colspan);
        $bodysp="";
        for($i=0;$i<$lengthbase;$i++){
            $bodysp.=$this->bodyspace;
        }
        $this->temporer_column.=$this->border.$bodysp;
        return $this;
    }

    /**
     * get the Table Text
     * @return string
     */
    public function getText(){
        $result=$this->initline."\n";
        $result.=$this->header;
        $result.=$this->initline."\n";
        $result.=$this->body;
        if(!$this->is_used_bodyspace || $this->bodyspace=="" || $this->bodyspace==" ")
            $result.=$this->initline."\n";
        $result.=$this->footer;
        $result.=$this->initline;
        return $result;
    }

    /**
     * adding line in the Table
     * @param string $commit should be header, body or footer
     * @return TableText
     */
    public function addLine($commit){
        if($commit=="header"){
            $this->header.=$this->initline."\n";
        }else if($commit=="body"){
            $this->body.=$this->initline."\n";
        }else if($commit=="footer"){
            $this->footer.=$this->initline."\n";
        }
        return $this;
    }

    /**
     * adding space in the Table
     * @param string $commit should be header, body or footer
     * @return TableText
     */
    public function addSpace($commit){
        if($commit=="header"){
            $this->header.=$this->initspace."\n";
        }else if($commit=="body"){
            $this->body.=$this->initspace."\n";
        }else if($commit=="footer"){
            $this->footer.=$this->initspace."\n";
        }
        return $this;
    }

    /**
     * create the basis of the column width
     * @param  $width length of char width
     * @param unknown $column that wanted
     */
    private function initColumnBase($width,$column){
        $this->columnbase=array();
        if(strlen($this->line)>0){
            $width=$width-$column+1;
        }
        $part=floor($width/$column);
        for($p=0;$p<$part-1;$p++){
            $this->columnbase[]=$part;
            $width-=$part;
        }
        $this->columnbase[]=$width;
        return $this;
    }

    /**
     * return the column length of table
     */
    private function getColumnLength($index){
        return $this->columnbase[$index];
    }

    /**
     * set the column length base for each column
     * @param int $index
     * @param int $length
     */
    public function setColumnLength($index,$length){
        $this->columnbase[$index]=$length;
        return $this;
    }

    /**
     * make a space
     * @param unknown $number
     * @return string
     */
    private function space($number){
        $space="";
        for($i=0;$i<$number;$i++){
            $space.=" ";
        }
        return $space;
    }

    /**
     * make a line
     * @param unknown $number
     * @return string
     */
    private function line($number){
        if($this->line=="") return "";
        $line="";
        for($i=0;$i<$number;$i++){
            $line.=$this->line;
        }
        return $line;
    }

    /**
     * create a border
     * @param unknown $number
     * @return string
     */
    private function border($number){
        if($this->border=="") return "";
        $border="";
        for($i=0;$i<$number;$i++){
            $border.=$this->border;
        }
        return $border;
    }
}