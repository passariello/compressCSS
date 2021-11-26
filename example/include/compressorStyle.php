<?php
  # Copyright Dario Passariello (c) 2016

  # Inform browser about mime
  header("Content-type: text/css; charset: UTF-8");

  # Clean formatting and remove extra stuff
  function compressorStyle($line){
    $write_css_content = $line;
    $write_css_content = trim($write_css_content);
    $write_css_content = preg_replace("/\s{2,}/", "", $write_css_content);
    $write_css_content = preg_replace('/^\s+/', ' ', $write_css_content);
    $write_css_content = str_replace("\n", " ", $write_css_content);
    $write_css_content = str_replace(', ', ",", $write_css_content);
    $write_css_content = preg_replace('/[\s]*([\{\},;:])[\s]*/', '\1', $write_css_content);
    $write_css_content = preg_replace('#/\*.*?\*/#', ' ', $write_css_content);
    $write_css_content = preg_replace('/[[:blank:]]+/', ' ', $write_css_content);
    $write_css_content = preg_replace('!//[^\n\r]+!', ' ', $write_css_content);
    $write_css_content = preg_replace('/[\r\n\t\s]+/s', ' ', $write_css_content);
    $write_css_content = preg_replace('/ +/', ' ', $write_css_content);
    $write_css_content = strtr($write_css_content,':0px',':0');
    $write_css_content = str_replace( "http://","http:\/\/",$write_css_content );

    return $write_css_content;
  }

/*******************************************************************************************/

  # Grab all style from a folder
  function print_css( $path , $comp ){

    $iter = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . $path, RecursiveDirectoryIterator::SKIP_DOTS),
      RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
    );

    $paths = array($path);

    foreach ($iter as $path => $dir) {

      $valfin = $path;
      $exp = explode('.', $valfin);
      $valfin_end = end($exp);

      if($dir->isDir()) {
        $valfin = $valfin;
      }
      $paths[] = $valfin;

    }

    if($paths > ''){
      sort($paths);
    }

    for($i=0; $i < count($paths); ++$i){

    $check = explode('.', $paths[$i]);
    $file_extension = end($check);

      # check for archives (#OLD folders) and .DAV if used
      if (strpos($paths[$i], "#OLD") === false && strpos($paths[$i], ".DAV") === false){

        # conpress only CSS (but you can use for less or sass too)
        if($file_extension == "css" ){
          $code .= file_get_contents( $paths[$i] );
        }
      }

    }

    # run compression
    if( $comp === true ){
      return compressorStyle( $code );
    }else{
      return $code;
    }

  }

# output
echo <<< EOT
  /*
    CREATED BY DARIO PASSARIELLO
    copyright (c) 2016

    The MIT License (MIT)
    Copyright (c) 2016 Dario Passariello
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:
    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
  */
  \n\n
EOT;

  # you need to provide the right folder.
  echo print_css( '/css/' , true );

?>
