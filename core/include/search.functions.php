<?php

	/*	This file is part of Jetbird.

	    Jetbird is free software: you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation, either version 3 of the License, or
	    (at your option) any later version.

	    Jetbird is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.

	    You should have received a copy of the GNU General Public License
	    along with Jetbird.  If not, see <http://www.gnu.org/licenses/>.
	*/

/*
 * Thanks to http://nadeausoftware.com/articles/2007/9/php_tip_how_strip_punctuation_characters_web_page and the other articles referenced there
 * for the code, the following function is licensed under the OSI BSD
 */
function clean_text( $text )
{
	$text = stripslashes($text);
	/*
	 * Removing HTML tags
	 */
	    $text = preg_replace(
	        array(
	          // Remove invisible content
	            '@<head[^>]*?>.*?</head>@siu',
	            '@<style[^>]*?>.*?</style>@siu',
	            '@<script[^>]*?.*?</script>@siu',
	            '@<object[^>]*?.*?</object>@siu',
	            '@<embed[^>]*?.*?</embed>@siu',
	            '@<applet[^>]*?.*?</applet>@siu',
	            '@<noframes[^>]*?.*?</noframes>@siu',
	            '@<noscript[^>]*?.*?</noscript>@siu',
	            '@<noembed[^>]*?.*?</noembed>@siu',
	          // Add line breaks before and after blocks
	            '@</?((address)|(blockquote)|(center)|(del))@iu',
	            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
	            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
	            '@</?((table)|(th)|(td)|(caption))@iu',
	            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
	            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
	            '@</?((frameset)|(frame)|(iframe))@iu',
	        ),
	        array(
	            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
	            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
	            "\n\$0", "\n\$0",
	        ),
	        $text );
	        
	    //decoding HTML entities for further processing
	   	//$text =  html_entity_decode( $text, ENT_QUOTES, "utf-8" );
    
	/*
	 * Stripping all punctuations.
	 */
	    $urlbrackets    = '\[\]\(\)';
	    $urlspacebefore = ':;\'_\*%@&?!' . $urlbrackets;
	    $urlspaceafter  = '\.,:;\'\-_\*@&\/\\\\\?!#' . $urlbrackets;
	    $urlall         = '\.,:;\'\-_\*%@&\/\\\\\?!#' . $urlbrackets;
	 
	    $specialquotes  = '\'"\*<>';
	 
	    $fullstop       = '\x{002E}\x{FE52}\x{FF0E}';
	    $comma          = '\x{002C}\x{FE50}\x{FF0C}';
	    $arabsep        = '\x{066B}\x{066C}';
	    $numseparators  = $fullstop . $comma . $arabsep;
	 
	    $numbersign     = '\x{0023}\x{FE5F}\x{FF03}';
	    $percent        = '\x{066A}\x{0025}\x{066A}\x{FE6A}\x{FF05}\x{2030}\x{2031}';
	    $prime          = '\x{2032}\x{2033}\x{2034}\x{2057}';
	    $nummodifiers   = $numbersign . $percent . $prime;
	 
	    $text =  preg_replace(
	        array(
	        // Remove separator, control, formatting, surrogate,
	        // open/close quotes.
	            '/[\p{Z}\p{Cc}\p{Cf}\p{Cs}\p{Pi}\p{Pf}]/u',
	        // Remove other punctuation except special cases
	            '/\p{Po}(?<![' . $specialquotes .
	                $numseparators . $urlall . $nummodifiers . '])/u',
	        // Remove non-URL open/close brackets, except URL brackets.
	            '/[\p{Ps}\p{Pe}](?<![' . $urlbrackets . '])/u',
	        // Remove special quotes, dashes, connectors, number
	        // separators, and URL characters followed by a space
	            '/[' . $specialquotes . $numseparators . $urlspaceafter .
	                '\p{Pd}\p{Pc}]+((?= )|$)/u',
	        // Remove special quotes, connectors, and URL characters
	        // preceded by a space
	            '/((?<= )|^)[' . $specialquotes . $urlspacebefore . '\p{Pc}]+/u',
	        // Remove dashes preceded by a space, but not followed by a number
	            '/((?<= )|^)\p{Pd}+(?![\p{N}\p{Sc}])/u',
	        // Remove consewcutive spaces
	            '/ +/',
	        ),
	        ' ',
	        $text );
	        
    /*
     * Stripping all symbols
     */
		$plus   = '\+\x{FE62}\x{FF0B}\x{208A}\x{207A}';
	    $minus  = '\x{2012}\x{208B}\x{207B}';
	 
	    $units  = '\\x{00B0}\x{2103}\x{2109}\\x{23CD}';
	    $units .= '\\x{32CC}-\\x{32CE}';
	    $units .= '\\x{3300}-\\x{3357}';
	    $units .= '\\x{3371}-\\x{33DF}';
	    $units .= '\\x{33FF}';
	 
	    $ideo   = '\\x{2E80}-\\x{2EF3}';
	    $ideo  .= '\\x{2F00}-\\x{2FD5}';
	    $ideo  .= '\\x{2FF0}-\\x{2FFB}';
	    $ideo  .= '\\x{3037}-\\x{303F}';
	    $ideo  .= '\\x{3190}-\\x{319F}';
	    $ideo  .= '\\x{31C0}-\\x{31CF}';
	    $ideo  .= '\\x{32C0}-\\x{32CB}';
	    $ideo  .= '\\x{3358}-\\x{3370}';
	    $ideo  .= '\\x{33E0}-\\x{33FE}';
	    $ideo  .= '\\x{A490}-\\x{A4C6}';
	 
	    $text =  preg_replace(
	        array(
	        // Remove modifier and private use symbols.
	            '/[\p{Sk}\p{Co}]/u',
	        // Remove mathematics symbols except + - = ~ and fraction slash
	            '/\p{Sm}(?<![' . $plus . $minus . '=~\x{2044}])/u',
	        // Remove + - if space before, no number or currency after
	            '/((?<= )|^)[' . $plus . $minus . ']+((?![\p{N}\p{Sc}])|$)/u',
	        // Remove = if space before
	            '/((?<= )|^)=+/u',
	        // Remove + - = ~ if space after
	            '/[' . $plus . $minus . '=~]+((?= )|$)/u',
	        // Remove other symbols except units and ideograph parts
	            '/\p{So}(?<![' . $units . $ideo . '])/u',
	        // Remove consecutive white space
	            '/ +/',
	        ),
	        ' ',
	        $text );
	        
	//finally convert the string to lowercase
    $text = mb_strtolower( $text, "utf-8" );
    
    return $text;
}

function split_text($text)
{
		//we assume from now on that all the text we recieve is UTF-8.
		
		//remove all punctuations and unwanted symbols.
		$text = clean_text($text);
		
		//splitting the words with mb_split as the explode() function isn't safe on UTF-8
		mb_regex_encoding( "utf-8" );
		$text = mb_split( ' +', $text );
		
		return $text;
}

/*
 * This function builds some queries for the search engine
 */
function create_query($base_query, $and_or, $loop_var, $row, $operator) {
	foreach($loop_var as $var) {
		if(empty($append)) {
			$append = " ". $row ." = '". $var ."' ". $and_or ."";
		}
		else
		{
			$append .= " OR ". $row ." = '". $var ."' ". $and_or ."";
		}
		
	$query = $base_query . $append;
	}
	return $query;

}

?>