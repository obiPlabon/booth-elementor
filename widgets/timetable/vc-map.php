<?php
array(

array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("or choose Google font", "timetable"),
	"param_name" => "font",
	"value" => $google_fonts_array,
),
array(
	"type" => "dropdownmulti",
	"class" => "",
	"heading" => __("Google font subset", "timetable"),
	"param_name" => "font_subset",
	"value" => array(
		"",
		"arabic",
		"hebrew",
		"telugu",
		"cyrillic-ext",
		"cyrillic",
		"devanagari",
		"greek-ext",
		"greek",
		"vietnamese",
		"latin-ext",
		"latin",
		"khmer",
	),
	"dependency" => array(
		"element" => "font",
		"not_empty" => true,
		"callback" => "timetable_font_subset_init",
	),
),

);
