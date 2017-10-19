<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 20/05/16
 * Time: 17:52
 */

namespace PostBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class NewsServices
{
    protected $container;
    protected $assets_url ;
    protected $phantomjs_path ;
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->assets_url = "https://www.tounsia.net/";
        $this->phantomjs_path = "/var/www/tounsia/PhantomJS/";
    }
    public function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public function dump($data, $tst = true)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($tst)
            exit;
    }

    public function isMobile(Request $request)
    {
        $useragent = $request->headers->get('User-Agent');

        if (!$useragent) {
            return false;
        }

        return  (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)));
    }

    public function generatePDFOrImage($htmlContent, $pdf = true, $orientation = "portrait", $image_width = 0, $image_height = 0)
    {
        $app_path = $this->container->get('kernel')->getRootdir();
        $tmp_path = $app_path . "/../web/tmp";

        if (!file_exists($tmp_path)) {
            mkdir($tmp_path, 0777, true);
        }

        $tmp_filename = "tmp" . rand() . ".html";
        $tmp_html_file = "$tmp_path/$tmp_filename";
        $tmp_url = $this->assets_url . "tmp/$tmp_filename";
        file_put_contents($tmp_html_file, $htmlContent);


        $cmd = "$this->phantomjs_path/phantomjs --web-security=false --ignore-ssl-errors=true --disk-cache=true --disk-cache-path=\"$app_path/cache/phantomjs\"";
        if ($this->container->hasParameter('debug_pdf')) {
            if ($this->container->getParameter('debug_pdf')) {
                $cmd .= " --debug=true";
            }
        }
        $cmd .= " $this->phantomjs_path/html2Pdf.js";
        if ($pdf) {
            $tmp_file = str_replace(".html", ".pdf", $tmp_html_file);
            $html_footer = "<div style='text-align:center;position:relative;'><span class='page'></span> / <span class='topage'></span></div><div style='width: 130px;height: 77px;position: absolute;right: 0;top:0;z-index:99999;'><img src='" . $this->assets_url . "assetic/images/dashboard_pdf_gvfooter.png'></div>";
            $cmd .= " -footer_content \"$html_footer\" -header_height 0 -margin_top 0 -margin_right 0 -orientation " . $orientation;
            //PDF generation timeout
            if (!defined("HOME_PAGE_TIMEOUT")) {
                @include_once KANDD_PATH . "/databases/scripts/conf/global-config.inc.php";
            }
            if (defined("HOME_PAGE_TIMEOUT") and HOME_PAGE_TIMEOUT) {
                $cmd .= " -timeout " . HOME_PAGE_TIMEOUT;
            }
        } else {
            $tmp_file = str_replace(".html", ".png", $tmp_html_file);
            $cmd .= " -export_image";
            if ($image_width) {
                $cmd .= " -image_width " . $image_width;
            }
            if ($image_height) {
                $cmd .= " -image_height " . $image_height;
            }
        }

        $log_file = "$app_path/logs/phantomjs.log";
        $cmd .= " -page_url $tmp_url -result \"$tmp_file\" >> \"$log_file\" 2>&1";

        error_log("\n" . date("d-M-Y H:i:s") . " - NEW GENERATION\n$cmd\n", 3, $log_file);

        exec($cmd);

        return $tmp_file;
    }
}