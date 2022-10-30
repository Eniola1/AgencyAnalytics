<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    
    <div class="">

        <?php 
        
            $total_pages = 4; $single = ''; $singleImages = 0; $totalImages = 0; $singleLinks = 0;
            $totalLinks = 0;

            $x = ['automated-marketing-reports','seo-tools','white-label', 'custom-marketing-dashboards'];

            for($p =0; $p < $total_pages; $p++)
            {
                $page_contents = file_get_contents('https://agencyanalytics.com/feature/'.$x[$p].'');

                if($page_contents !== FALSE && !empty($page_contents))
                {
                    //  Extract all unique pictures

                    //Page load time 
                    $start_time = microtime(TRUE);
                    $end_time = microtime(TRUE);
                    $time_taken =($end_time - $start_time)*1000;
                    $time_taken = round($time_taken, 5);
    

                    $main_contents = explode('<main id="main" role="main">', $page_contents);
                    $main_contents = explode('</main>', $main_contents[1]);

                    //word count 
                    $wrd1 = str_word_count($main_contents[0]);
                    $wrd2 = str_word_count($main_contents[1]);

                    //total word count
                    $wrd = $wrd1 + $wrd2;

                    //Average word count
                    $wrd = $wrd / 2;


                    //Each picture
                    $pictures = explode('<section ', $main_contents[0]);
                    array_shift($pictures);

                    for($i = 0; $i < count($pictures); $i++)
                    {
                        //Extract main image 
                        $main_image = explode('<picture class="picture"', $pictures[$i]);
                        $main_image = explode('<img src="', $main_image[1]);
                        $main_image = explode('"', $main_image[1]);
                        $main_images = trim($main_image[0]);

                        for($i = 0; $i < count($main_image); $i++)
                        {
                            $singleImages += 1;
                        }

                        // Extract post title along with it's link

                        // $links = explode('<p>', $pictures[$i]);
                        // $links = explode('</p>', $links[1]); 
                        // $link = trim($links[0]);

                        // for($i = 0; $i < count($links); $i++)
                        // {
                        //    $singleLinks += 1; $totalLinks += 1;
                        // }
                    }
                }

                $totalImages += $singleImages;

                //To get status code 

                $url = 'https://agencyanalytics.com/feature/'.$x[$p].'';
                $headers = get_headers($url);
                $status = substr($headers[0], 9, 3);
                        
                $single .= "
                    
                    <table>
                        <tr>
                            <th>Page</th>
                            <th>Number of Images</th>
                            <th>Number of Links</th>
                            <th>Average page loads(sec)</th>
                            <th>Average word count</th>
                            <th>HTTP status code</th>
                        </tr>
                        <tr>
                            <td>$url</td>
                            <td>$singleImages</td>
                            <td>$singleLinks</td>
                            <td>$time_taken</td>
                            <td>$wrd</td>
                            <td>$status</td>
                        </tr>
                    </table>
                ";
            }

            echo " 
                    <table>
                        <tr>
                            <th>Total Pages crawled</th>
                            <th>Total Images</th>
                        </tr>
                        <tr>
                            <td>$total_pages</td>
                            <td>$totalImages</td>
                        </tr>
                    </table>
                ";

            echo $single;
        
        ?>

    </div>

</body>
</html>


