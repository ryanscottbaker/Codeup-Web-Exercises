<?php include '../templates/header.php' ?>


<?php
	$albums = [
		['artist' => 'Thrice',
		 'title' => 'The Illusion of Safety',
		 'released' => '2002'
		],[
		 'artist' => 'Thursday',
		 'title' => 'War All The Time',
		 'released' => '2005'
		],[
		 'artist' => 'Garth Brooks',
		 'title' => 'Ropin The Wind',
		 'released' => '2002'

		],[
		 'artist' => 'The Killers',
		 'title' => 'Hot Fuss',
		 'released' => '2003'
		],[
		 'artist' => 'Heavy, Heavy, Low, Low',
		 'title' => 'Courtside Seats',
		 'released' => '2005'
		]
];

var_dump($albums);

foreach ($albums as $index => $album) {
    echo "The band {$album['artist']} is one of my favorite artists and {$album['title']} is one of my favorite albums this album was released in {$album['released']} \n";
};

?>


<?php include '../templates/footer.php' ?>
