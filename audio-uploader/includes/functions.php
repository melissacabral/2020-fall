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

/*
THE FOLLOWING  FUNCTIONS ALREADY EXIST IN THE IMAGE APP. delete them if combining these two projects!
*/

//Functions to sanitize data safely for the database
function clean_string( $dirty ){
    global $db;
    $clean = mysqli_real_escape_string( $db, filter_var( $dirty, FILTER_SANITIZE_STRING ) );
    return $clean;
}
function clean_int( $dirty ){
    global $db;
    $clean = mysqli_real_escape_string( $db, filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT ) );
    return $clean;
}


//Display feedback from a typical form 
function show_feedback( $heading, $class = 'error', $bullets = array() ){
    if( isset($heading) ){
    ?>
    <div class="feedback <?php echo $class; ?>">
        <h3><?php echo $heading; ?></h3>
        
        <?php if( !empty($bullets) ){ ?>
        <ul>
            <?php foreach( $bullets as $bullet ){
                echo "<li>$bullet</li>";
            } ?>
        </ul>
        <?php } //end if bullets not empty ?>

    </div>
    <?php
    }//end if heading exists
}
