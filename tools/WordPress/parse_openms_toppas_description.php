<?php
/**
 * @package Parse_TOPPAS_Description
 * @version 0.1
 */
/*
Plugin Name: OpenMS TOPPAS Description Extractor
Plugin URI: none
Description: Use this plugin on our Wordpress homepage to show the 'description' of a TOPPAS workflow close to its filename automatically. Usage: put "!!!!<URL_link_to_toppas_file>####" in a wordpress page, e.g. !!!!http://openms.de/wp-content/uploads/2011/08/BSA_Quantitation.toppas####
Author: Chris Bielow
Version: 0.1
Author URI: http://openms.de
*/

function otd_get_plugin_file()
{
		//You'd be surprised on how useful this can be. 
		return __FILE__; 
}

function displayLink($matches)
{
  $linkURL = $matches[1]; ## e.g. http://localhost/wordpress/wp-content/uploads/2011/08/BSA_Quantitation.toppas
  $url_file_suffix = preg_replace ( '/.*wp-content(.*)/i' , "$1" ,  $linkURL );
  $url_toppas = pathinfo($linkURL);

  $url_plugin = pathinfo(otd_get_plugin_file()); ## e.g. #C:\xampplite\htdocs\wordpress\wp-content\plugins\openms_toppas_description.php
  
  $local_file = $url_plugin['dirname']."/..".$url_file_suffix;  ## C:\xampplite\htdocs\wordpress\wp-content\plugins\..\<rest>
  $local_file = realpath($local_file); ## will return FALSE if file does not exist!
  #return  "loading:".$local_file; 
  
  
  if ($local_file) 
  {
    ## get .toppas file's Description tag
    $file_content = file_get_contents($local_file);

    $xml = new SimpleXMLElement($file_content);
    $desc = '';
    /* Access the @value of the workflow description */
    foreach ($xml->NODE as $nodes) 
    {
      switch((string) $nodes['name']) 
      { // Get attributes as element indices
        case 'info':
          foreach ($nodes->ITEM as $items)
          {
            switch((string) $items['name'])
            {
             case 'description':
              $desc = $items['value'];
              break;
            }
          }
          break;
      }
    }

    ## remove eventual CDATA stuff and get the body!!!
    $desc = preg_replace ( '/<\!\[CDATA\[(.*)\]\]>/i' , "$1" ,  $desc );
    $description = preg_replace ( '/.*body([^>]*)>(.*)<\/body.*/i' , "$2" ,  $desc );
    
    $parsed_url = pathinfo($local_file);
    $file_ref = '<a href="'. $linkURL .'" target="_blank">'. $parsed_url['basename'] .'</a>';
  }  
  else
  {
    $description = "File not found! Please notify admin!";
    $file_ref = $url_toppas['basename'];
  }
  
	$rnd_class = mt_rand();
	
  $text = '<div style="border:1px dashed;">
					File: '.$file_ref.'<br>
					Description: <button class="'.$rnd_class.'">Show/Hide</button>
							<span class="'.$rnd_class.'_e" style="display: none; ></span>
							<span class="'.$rnd_class.'_e" style="display:inline-block; vertical-align:top">'. $description .'</span>
					</div>';
  
  return $text;
}

function displayTOPPASEntry($content)
{

  return preg_replace_callback ( "/!!!!(.*\.toppas)####/i" , "displayLink" ,  $content );
#  return "Grabbing page content: ".$content."!";
}

function getExtraCode()
{
	$text = <<<'EOT'
		<script src="jquery-1.6.1.min.js"></script>
    <script>
      $(document).ready(function() 
			{
				$("button").click(function () {
														var id = "."+ $(event.target).attr("class");
														$(id + "_e").toggle();
													}
												 );
			});// document ready
    </script>
	EOT;
	return $text;
}


add_filter('the_content', 'displayTOPPASEntry')

?>