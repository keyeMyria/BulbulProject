<?php
/**
 * Created by PhpStorm.
 * User: fatih
 * Date: 22/03/2017
 * Time: 17:30
 */

namespace App\GraphQL\Fields;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Field;

class TracksField extends Field
{
    protected $attributes = [
        'description' => 'Tracks of the entity'
    ];

    public function type(){
        return Type::listOf(GraphQL::type('Track'));
    }

    public function args()
    {
        return [
            'limit' => ['description' => 'Number of tracks to be fetched', 'type' => Type::int()],
            'skip' => ['description' => 'Number of tracks to be skipped', 'type' => Type::int()],
        ];
    }

    protected function resolve($root, $args,$context, GraphQL\Type\Definition\ResolveInfo $info)
    {

        if(!isset($args['limit']) && !isset($args['skip'])){
            if (!$root->relationLoaded('tracks')) $root->load('tracks');
            return $root->getRelation('tracks');
        }
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        return $root->tracks()->whereNotNull('spotify_album_id')->take($limit)->skip($skip)->get();
    }
}