<?php 
/**
 * Stronger way to check MIME type of an uploaded file. 
 * Gets real MIME type and then see if its on allowed list
 * 
 * @param string $tmp : path to file
 * @return string [type]: MIME type from the actual file if allowed or FALSE if not an allowed MIME type
 * @see https://gist.github.com/AlexPashley/6130489
 */
function check_file_is_audio( $tmp ) 
{
    $allowed = array(
        'audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/aiff', 
        'audio/mid', 'audio/x-aiff', 'audio/x-mpequrl','audio/midi', 'audio/x-mid', 
        'audio/x-midi','audio/wav','audio/x-wav','audio/xm','audio/x-aac','audio/basic',
        'audio/flac','audio/mp4','audio/x-matroska','audio/ogg','audio/s3m','audio/x-ms-wax',
        'audio/xm'
    );
    
    // check REAL MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($finfo, $tmp );
    finfo_close($finfo);
    
    // check to see if REAL MIME type is inside $allowed array
    if( in_array($type, $allowed) ) {
        return $type;
    } else {
        return false;
    }
} 
$sound = 'audio/example_sample_ef8d868557d40d7e033844c4a0500ab5437c17f5.mp3';
// $sound = 'audio/not_a_song_54792c324bcb05723722c994294f066de59b0860.mp3';


echo check_file_is_audio($sound);
?>