<?php

namespace App\GraphQL\Type;

use App\Track;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;


class BulbulUserType extends GraphQLType
{

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user'
            ],
            'username' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of user'
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'The image of user'
            ],
            'lastActivePlaylist' => [
                'type' => Type::nonNull(GraphQL::type('Playlist')),
                'description' => 'The last active playlist of user'
            ],
            'recommendations' => [
                'type' => Type::listOf(GraphQL::type('Recommendation')),
                'description' => 'Recommendations belongs to the user'
            ],
            'ratedTracks' => [
                'type' => Type::listOf(GraphQL::type('Track')),
                'description' => 'The rated tracks of user',
                'args' => [
                    'limit' => ['description' => 'Number of tracks to be fetched', 'type' => Type::int()],
                    'skip' => ['description' => 'Number of tracks to be skipped', 'type' => Type::int()],
                ]
            ],
            'listenedTracks' => [
                'type' => Type::listOf(GraphQL::type('Track')),
                'description' => 'The listened songs of user',
                'args' => [
                    'limit' => ['description' => 'Number of tracks to be fetched', 'type' => Type::int()],
                    'skip' => ['description' => 'Number of tracks to be skipped', 'type' => Type::int()],
                ]
            ],
            'listenedArtists' => [
                'type' => Type::listOf(GraphQL::type('Artist')),
                'description' => 'The listened artists of user',
                'args' => [
                    'limit' => ['description' => 'Number of artists to be fetched', 'type' => Type::int()],
                    'skip' => ['description' => 'Number of artists to be skipped', 'type' => Type::int()],
                ]
            ],
            'listenedAlbums' => [
                'type' => Type::listOf(GraphQL::type('Album')),
                'description' => 'The listened albums of user',
                'args' => [
                    'limit' => ['description' => 'Number of albums to be fetched', 'type' => Type::int()],
                    'skip' => ['description' => 'Number of albums to be skipped', 'type' => Type::int()],
                ]
            ],
            'followedPlaylists' => [
                'type' => Type::listOf(GraphQL::type('Playlist')),
                'description' => 'The followed playlists of user'
            ],
            'listenedPlaylists' => [
                'type' => Type::listOf(GraphQL::type('Playlist')),
                'description' => 'The listened playlists of user'
            ],
            'playlists' => [
                'type' => Type::listOf(GraphQL::type('Playlist')),
                'description' => 'Playists created by user',
                'args' => [
                    'limit' => ['description' => 'Number of playlists to be fetched', 'type' => Type::int()],
                    'skip' => ['description' => 'Number of playlists to be skipped', 'type' => Type::int()],
                ]

            ],
            'followers' => [
                'type' => Type::listOf(GraphQL::type('BulbulUser')),
                'description' => 'Followers of user',
                'args' => [
                    'limit' => ['description' => 'Number of followers to be fetched', 'type' => Type::int()],
                    'skip' => ['description' => 'Number of followers to be skipped', 'type' => Type::int()],
                ]
            ],
            'followersCount' => [
                'type' => Type::int(),
                'description' => 'The number of followers'
            ],
            'followedUsers' => [
                'type' => Type::listOf(GraphQL::type('BulbulUser')),
                'description' => 'Followed users of user',
                'args' => [
                    'limit' => ['description' => 'Number of followed users to be fetched', 'type' => Type::int()],
                    'skip' => ['description' => 'Number of followed users to be skipped', 'type' => Type::int()],
                ]
            ],
            'followedUsersCount' => [
                'type' => Type::int(),
                'description' => 'The number of followedUsers'
            ]
        ];
    }
    protected function resolvePlaylistsField($root, $args)
    {
        if (!isset($args['limit']) && !isset($args['skip'])) {
            if (!$root->relationLoaded('playlists')) $root->load('playlists');
            return $root->getRelation('playlists');
        }
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        return $root->playlists()->orderBy('created_at', 'DESC')->take($limit)->skip($skip)->get();
    }

    protected function resolveFollowersField($root, $args)
    {
        if (!isset($args['limit']) && !isset($args['skip'])) {
            if (!$root->relationLoaded('followers')) $root->load('followers');
            return $root->getRelation('followers');
        }
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        return $root->followers()->take($limit)->skip($skip)->get();
    }

    protected function resolveFollowedUsersField($root, $args)
    {
        if (!isset($args['limit']) && !isset($args['skip'])) {
            if (!$root->relationLoaded('followedUsers')) $root->load('followedUsers');
            return $root->getRelation('followedUsers');
        }
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        return $root->followedUsers()->take($limit)->skip($skip)->get();
    }

    protected function resolveListenedTracksField($root, $args)
    {
        if (!isset($args['limit']) && !isset($args['skip'])) {
            if (!$root->relationLoaded('listenedTracksRelation')) $root->load('listenedTracksRelation');
            return $root->listenedTracksRelation;
        }
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        return $root->listenedTracksRelation()->whereNotNull('spotify_album_id')->take($limit)->skip($skip)->get();
    }

    protected function resolveListenedArtistsField($root, $args)
    {
        if (!isset($args['limit']) && !isset($args['skip'])) {
            if (!$root->relationLoaded('listenedArtists')) $root->load('listenedArtists');
            return $root->getRelation('listenedArtists');
        }
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        return $root->listenedArtists()->take($limit)->skip($skip)->get();
    }

    protected function resolveListenedAlbumsField($root, $args)
    {
        if (!isset($args['limit']) && !isset($args['skip'])) {
            if (!$root->relationLoaded('listenedAlbums')) $root->load('listenedAlbums');
            return $root->getRelation('listenedAlbums');
        }
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        return $root->listenedAlbums()->take($limit)->skip($skip)->get();
    }

    protected function resolveRatedTracksField($root, $args)
    {
        $limit = isset($args['limit']) ? $args['limit'] : 100;
        $skip = isset($args['skip']) ? $args['skip'] : 0;
        $ratings = $root->ratings()->orderBy('updated_at', 'DESC')->take($limit)->skip($skip)->get();
        $rated_track_ids = $ratings->pluck('track_id')->toArray();
        $tracks = Track::whereIn('id',$rated_track_ids)->whereNotNull('spotify_album_id')->get();
        foreach($tracks as $key=>$track){
            $track->rating = $ratings[$key];
        }
        return $tracks;
    }

}