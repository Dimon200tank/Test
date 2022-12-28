<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>отправка csv файла</title>
</head>
<body>
    <form action="" method="get">
        <input type="file" name="file" id="">
        <button type="submit">отправить</button>
    </form>
</body>
</html>
<?php

function create_file( $create_data, $file = "", $col_delimiter = ';', $row_delimiter = "\r\n" ){

	if( ! is_array( $create_data ) ){
		return false;
	}

	if( $file && ! is_dir( dirname( $file ) ) ){
		return false;
	}

	$str = '';

	foreach( $create_data as $row ){
		$cols = array();

		foreach( $row as $col_val ){
			$cols[] = $col_val;
		}
		$str .= implode( $col_delimiter, $cols ) . $row_delimiter;
	}

    $done = file_put_contents( $file, $str );

}

function parse_file( $file_path, $file_encodings = ['cp1251','UTF-8'], $col_delimiter = '', $row_delimiter = '' ){

	if( ! file_exists( $file_path ) ){
		return false;
	}

	$cont = trim( file_get_contents( $file_path ) );

	$encoded_cont = mb_convert_encoding( $cont, 'UTF-8', mb_detect_encoding( $cont, $file_encodings ) );

	unset( $cont );

	if( ! $row_delimiter ){
		$row_delimiter = "\r\n";
		if( false === strpos($encoded_cont, "\r\n") )
			$row_delimiter = "\n";
	}

	$lines = explode( $row_delimiter, trim($encoded_cont) );
	$lines = array_filter( $lines );
	$lines = array_map( 'trim', $lines );

	if( ! $col_delimiter ){
		$lines10 = array_slice( $lines, 0, 30 );

		foreach( $lines10 as $line ){
			if( ! strpos( $line, ',') ) $col_delimiter = ';';
			if( ! strpos( $line, ';') ) $col_delimiter = ',';

			if( $col_delimiter ) break;
		}

		if( ! $col_delimiter ){
			$delim_counts = array( ';'=>array(), ','=>array() );
			foreach( $lines10 as $line ){
				$delim_counts[','][] = substr_count( $line, ',' );
				$delim_counts[';'][] = substr_count( $line, ';' );
			}

			$delim_counts = array_map( 'array_filter', $delim_counts );

			$delim_counts = array_map( 'array_count_values', $delim_counts );

			$delim_counts = array_map( 'max', $delim_counts ); 

			if( $delim_counts[';'] === $delim_counts[','] )
				return array('Не удалось определить разделитель колонок.');

			$col_delimiter = array_search( max($delim_counts), $delim_counts );
		}

	}

	$data = [];
	foreach( $lines as $key => $line ){
		$data[] = str_getcsv( $line, $col_delimiter );
		unset( $lines[$key] );
	}

	return $data;
}

$newFile = $_GET['file'];

if ($newFile != '') {
    echo $newFile;
    $data = parse_file($newFile);

    foreach($data as $x){
        $ar = array(array($x[1]));
        $name = $x[0];
        echo create_file($ar, './upload/' . $name);
    }
}





?>