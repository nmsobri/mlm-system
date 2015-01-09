<?php

namespace Mlm\Libs\File;

use Illuminate\Config\FileLoader;

class MlmConfig extends FileLoader
{
    protected $data    = null;
    protected $content = null;
    protected $path    = null;


    public function save( $items, $group, $environment = null ,$namespace = null )
    {
        $this->path = $this->getPath( $namespace );
        if ( is_null( $this->path ) ) return;

        $file = ( !$environment || ( $environment == 'production' ) )
            ? "{$this->path}/mlm.php"
            : "{$this->path}/{$environment}/mlm.php";

        $this->extractData( file( $file ) );
        $this->pushData( $items );
        $this->writeData( $group );
    }


    protected function extractData( $datas )
    {
        foreach ( $datas as $data ) {
            if ( preg_match('#^\s+?([\'"])(.+?)\1\s+?=>\s?(.+?),#', $data,
                $matches ) ) {
                    $this->content[trim($matches[2],"'\"")] = $matches[3];
            }
        }
    }


    protected function pushData( $items )
    {
        foreach ( $items as $key => $val ) {
            $this->content[ $key ] = is_int( $val ) ? $val : sprintf( "'%s'", $val );
        }
    }


    protected function writeData( $group )
    {
        $content = "<?php\n\nreturn array(\n\n";

        foreach ( $this->content as $key => $data ) {
            $content .= sprintf( "\t'%s' => %s,\n", $key, $data );
        }

        $content .= sprintf( "\n);" );
        $this->files->put( "{$this->path}/{$group}.php", $content );

    }
}