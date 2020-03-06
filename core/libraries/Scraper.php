<?php
 
class Scraper
{

    public function get( $html, $tag, $selfclosing = null, $return_the_entire_tag = false, $charset = 'ISO-8859-1' ){
         
        if ( is_array($tag) ){
            $tag = implode('|', $tag);
        }
         
        //If the user didn't specify if $tag is a self-closing tag we try to auto-detect it
        //by checking against a list of known self-closing tags.
        $selfclosing_tags = array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta', 'col', 'param' );
        if ( is_null($selfclosing) ){
            $selfclosing = in_array( $tag, $selfclosing_tags );
        }
         
        //The regexp is different for normal and self-closing tags because I can't figure out 
        //how to make a sufficiently robust unified one.
        if ( $selfclosing ){
            $tag_pattern = 
                '@<(?P<tag>'.$tag.')           # <tag
                (?P<attributes>\s[^>]+)?       # attributes, if any
                \s*/?>                   # /> or just >, being lenient here 
                @xsi';
        } else {
            $tag_pattern = 
                '@<(?P<tag>'.$tag.')           # <tag
                (?P<attributes>\s[^>]+)?       # attributes, if any
                \s*>                 # >
                (?P<contents>.*?)         # tag contents
                </(?P=tag)>               # the closing </tag>
                @xsi';
        }
         
        $attribute_pattern = 
            '@
            (?P<name>\w+)                         # attribute name
            \s*=\s*
            (
                (?P<quote>[\"\'])(?P<value_quoted>.*?)(?P=quote)    # a quoted value
                |                           # or
                (?P<value_unquoted>[^\s"\']+?)(?:\s+|$)           # an unquoted value (terminated by whitespace or EOF) 
            )
            @xsi';
     
        //Find all tags 
        if ( !preg_match_all($tag_pattern, $html, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ){
            //Return an empty array if we didn't find anything
            return array();
        }
         
        $tags = array();
        foreach ($matches as $match){
             
            //Parse tag attributes, if any
            $attributes = array();
            if ( !empty($match['attributes'][0]) ){ 
                 
                if ( preg_match_all( $attribute_pattern, $match['attributes'][0], $attribute_data, PREG_SET_ORDER ) ){
                    //Turn the attribute data into a name->value array
                    foreach($attribute_data as $attr){
                        if( !empty($attr['value_quoted']) ){
                            $value = $attr['value_quoted'];
                        } else if( !empty($attr['value_unquoted']) ){
                            $value = $attr['value_unquoted'];
                        } else {
                            $value = '';
                        }
                         
                        //Passing the value through html_entity_decode is handy when you want
                        //to extract link URLs or something like that. You might want to remove
                        //or modify this call if it doesn't fit your situation.
                        $value = html_entity_decode( $value, ENT_QUOTES, $charset );
                         
                        $attributes[$attr['name']] = $value;
                    }
                }
                 
            }
             
            $tag = array(
                'tag_name' => $match['tag'][0],
                'offset' => $match[0][1], 
                'contents' => !empty($match['contents'])?trim($match['contents'][0]):'', //empty for self-closing tags
                'attributes' => $attributes, 
            );
            if ( $return_the_entire_tag ){
                $tag['full_tag'] = $match[0][0];            
            }
              
            $tags[] = $tag;
        }
         
        return $tags;
    }

}