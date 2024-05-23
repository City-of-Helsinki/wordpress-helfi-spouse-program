<?php
namespace Spouse;
require_once( get_stylesheet_directory() . '/lib/SimpleXLSXGen.php');

class RegisterFormAttachment
{
    function generateExcelFromSubmission( $posted_data )
	{
        if ( empty ($posted_data)){
            return;
        }

        $data = $this->tableHeadersFromArrayKeys($posted_data);
        $xlsx = \SimpleXLSXGen::fromArray( $data );


        $tmpfname = $this->generateTempFileName();
        $xlsx->saveAs( $tmpfname );

        return $tmpfname;
    }

    private function tableHeadersFromArrayKeys(array $data)
	{
        $tmp = array();
        $tmp[0] = array_keys($data);
        $tmp[1] = array_values($data);

        $tmp[1] = array_map(function($val){
            if (is_array($val)){
                return implode(', ', $val);
            }
            return $val;
        }, $tmp[1]);

        return $tmp;
    }

    private function generateTempFileName()
	{
        $uploads_dir = wpcf7_upload_tmp_dir();
        $uploads_dir = wpcf7_maybe_add_random_dir( $uploads_dir );
        $tmpfname = sprintf("%s.xlsx", tempnam($uploads_dir, "excel"));

        return $tmpfname;
    }
}
