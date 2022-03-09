<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pic_model extends Base_Model {

	private $upload_path = 'uploads/';
	function __construct(){
		parent::__construct ();
	}

    /* Generate Image */

    public function generate_image($w, $h, $text, $bgs){
        // $im = imagecreate($w, $h);
        $im = $this->gradient($w, $h, $bgs);

        $textcolor = imagecolorallocate($im, 255, 255, 255);

        $font = 'assets/fonts/jf-jinxuan-bold.otf';

        if(strstr($text, PHP_EOL)) {
            $text_split = explode("\n", $text);
            $line_height = 35;
            $start_y = 0;
            if (count($text_split) % 2 == 0) {
                $start_y = $line_height * (count($text_split) / 2) * -1;
            }else{
                $start_y = $line_height * floor(count($text_split) / 2 + 0.5) * -1;
            }

            for ($i=0; $i < count($text_split); $i++) { 
                $imgbox = imagettfbbox(20, 0, $font, $text_split[$i]);

                $x = $imgbox[0] + (imagesx($im) / 2) - ($imgbox[4] / 2);
                $y = $imgbox[1] + (imagesy($im) / 2) - ($imgbox[5] / 2) + 10 + $start_y;

                imagettftext($im, 20, 0, $x, $y, $textcolor, $font, $text_split[$i]);
                $start_y += $line_height;
            }
        }else{
            $imgbox = imagettfbbox(20, 0, $font, $text);

            $x = $imgbox[0] + (imagesx($im) / 2) - ($imgbox[4] / 2) - 0;
            $y = $imgbox[1] + (imagesy($im) / 2) - ($imgbox[5] / 2) - 0;

            imagettftext($im, 20, 0, $x, $y, $textcolor, $font, $text);
        }

        // Output the image
        header('Content-type: image/png');

        $path = $this->upload_path.date("ymdhis").uniqid().".png";
        imagepng($im, $path);
        // imagepng($im);
        imagedestroy($im);
        return $path;
    }
    function gradient($w=100, $h=100, $c=array('#FFFFFF','#FF0000','#00FF00','#FCD983'), $hex=true) {

        /*
        Generates a gradient image

        Author: Christopher Kramer

        Parameters:
        w: width in px
        h: height in px
        c: color-array with 4 elements:
            $c[0]:   top left color
            $c[1]:   top right color
            $c[2]:   bottom left color
            $c[3]:   bottom right color
           
        if $hex is true (default), colors are hex-strings like '#FFFFFF' (NOT '#FFF')
        if $hex is false, a color is an array of 3 elements which are the rgb-values, e.g.:
        $c[0]=array(0,255,255);

        */

        $im=imagecreatetruecolor($w,$h);

        if($hex) {  // convert hex-values to rgb
          for($i=0;$i<count($c);$i++) {
           $c[$i]=$this->hex2rgb($c[$i]);
          }
        }

        $rgb=$c[0]; // start with top left color
        for($x=0;$x<=$w;$x++) { // loop columns
          for($y=0;$y<=$h;$y++) { // loop rows
           // set pixel color
           $col=imagecolorallocate($im,$rgb[0],$rgb[1],$rgb[2]);
           imagesetpixel($im,$x-1,$y-1,$col);
           // calculate new color 
           for($i=0;$i<=2;$i++) {
            $rgb[$i]=
              $c[0][$i]*(($w-$x)*($h-$y)/($w*$h)) +
              $c[1][$i]*($x     *($h-$y)/($w*$h)) +
              $c[2][$i]*(($w-$x)*$y     /($w*$h)) +
              $c[3][$i]*($x     *$y     /($w*$h));
           }
          }
        }
        return $im;
    }



    private function hex2rgb($hex){
        $rgb[0]=hexdec(substr($hex,1,2));
        $rgb[1]=hexdec(substr($hex,3,2));
        $rgb[2]=hexdec(substr($hex,5,2));
        return($rgb);
    }

    /* crop */

    public function create_thumb($path, $thumb_width = 200){
        if (file_exists($path)) {
            $this->_createThumbnail($path, TRUE, "_s", $thumb_width, $thumb_width);
            return str_replace(".", "_s.", $path);    
        }
        return "";
    }
    
    public function crop_img_upload_and_create_thumb($name = "imageData", $dir = FALSE, $thumb_width = 500){
        return $this->crop_img_upload($name, $dir, TRUE, $thumb_width);
    }

    public function crop_img_upload($name = "imageData", $dir = FALSE, $createThumb = FALSE, $thumb_width = 700){
        $imageData = $this->input->post($name);
        $filepath = $this->upload_path . time() . uniqid() . ".jpg";
        if ($dir !== FALSE) {
            $filepath = $dir . time() . uniqid() . ".jpg";
        }
        $image = $this->base64_to_jpeg($imageData, $filepath);
        if ($createThumb) {
            $this->_createThumbnail($filepath, TRUE, "_s", 500, 500);
            $this->_createThumbnail($filepath, TRUE, "_m", 200, 200);
        }
        return $filepath;
    }

	private function base64_to_jpeg($base64_string, $output_file) {
	    $ifp = fopen( $output_file, 'wb' ); 
	    $data = explode( ',', $base64_string );
	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );
	    fclose( $ifp ); 
	    return $output_file; 
	}

	private function checkRotate($filepath){
		$imgdata=exif_read_data($filepath, 'IFD0');
 		
 		$config=array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $filepath;

        switch($imgdata['Orientation']) {
            case 3:
                $config['rotation_angle']='180';
                break;
            case 6:
                $config['rotation_angle']='270';
                break;
            case 8:
                $config['rotation_angle']='90';
                break;
        }

        $this->load->library('image_lib',$config); 
        $this->image_lib->clear();
        $this->image_lib->initialize($config); 
        $this->image_lib->rotate();
	}

	/* crop end */
	public function upload_pics_create_thumb($name, $count = FALSE){
        return $this->upload_pics($name, $count, TRUE);
    }

	public function upload_pics($name, $count = FALSE, $createThumb = FALSE){
		$this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;

        if ($count === FALSE) {
            $cpt = count($_FILES[$name]['name']);    
        }else{
            $cpt = $count;
            if (!is_numeric($cpt)) {
            	$cpt = 1;
            }
        }
        
        if ($cpt == 1 && !is_array($_FILES[$name]['name'])) {
            $ori = explode(".", $_FILES[$name]['name']);
            $_FILES[$name]['name']= date("ymdhis").uniqid().".".$ori[count($ori)-1];//
            $this->upload->initialize($this->set_upload_options());
            $this->upload->do_upload($name);
            $idata = $this->upload->data();

            $dataInfo[] = $idata;

            if ($createThumb) {
                $this->_createThumbnail($idata['full_path'], TRUE, "_m", 500, 500);    
            }
        }else{
            for($i=0; $i<$cpt; $i++)
            {
                $ori = explode(".", $files[$name]['name'][$i]);
                $_FILES['image'.$i]['name']= date("ymdhis").uniqid().".".$ori[count($ori)-1];//$files['image'.$cate_id]['name'][$i];
                $_FILES['image'.$i]['type']= $files[$name]['type'][$i];
                $_FILES['image'.$i]['tmp_name']= $files[$name]['tmp_name'][$i];
                $_FILES['image'.$i]['error']= $files[$name]['error'][$i];
                $_FILES['image'.$i]['size']= $files[$name]['size'][$i];    

                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload("image".$i);
                $idata = $this->upload->data();
                $dataInfo[] = $idata;

                // $this->_createThumbnail($idata['full_path'], TRUE, "_s", 110, 110);
                if ($createThumb) {
                    $this->_createThumbnail($idata['full_path'], TRUE, "_m", 500, 500);    
                }
                // if ($idata['image_width'] < 1000) {
                //     $this->_createThumbnail($idata['full_path'], TRUE, "_l", $idata['image_width'], $idata['image_width']);
                // }else{
                //     $this->_createThumbnail($idata['full_path'], TRUE, "_l", 1000, 1000);    
                // }
            }
        }
        $data = array();
        foreach ($dataInfo as $item) {
            array_push($data, $this->upload_path.$item['file_name']);
        }
        return $data;
	}
	
	private function set_upload_options()
    {   
        // if (!file_exists('assets/uploads/')) {
        //     $oldmask = umask(0);
        //     mkdir('assets/uploads/'.$brand_id, 0755);
        //     umask($oldmask);
        // }

        $config = array();
        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = '*';
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;

        return $config;
    }

    private function _createThumbnail($fileName, $isThumb, $thumbMarker="", $width = '', $height = '') {
        // 參數
        $config['image_library'] = 'gd2';
        $config['source_image'] = $fileName;
        $config['create_thumb'] = $isThumb;
        $config['maintain_ratio'] = TRUE;
        $config['master_dim'] = 'width';

        
        if(isset($thumbMarker) && $thumbMarker!=""){
          $config['thumb_marker'] = $thumbMarker;
        }
        $config['width'] = $width;
        $config['height'] = $height;
      
        $this->load->library('image_lib', $config);
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if(!$this->image_lib->resize()) echo $this->image_lib->display_errors();
    }
}