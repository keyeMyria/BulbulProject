<?php


return [

    // The prefix for routes
    'prefix' => 'graphql',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each routes
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    //     'mutation' => 'graphiql'
    // ]
    //
    // you can also disable routes by setting routes to null
    //
    // 'routes' => null,
    //
    'routes' => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Folklore\GraphQL\GraphQLController@query',
    //     'mutation' => '\Folklore\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers' => \Folklore\GraphQL\GraphQLController::class . '@query',

    // The name of the input that contain variables when you query the endpoint.
    // Some library use "variables", you can change it here. "params" will stay
    // the default for now but will be changed to "variables" in the next major
    // release.
    'variables_input_name' => 'variables',

    // Any middleware for the graphql route group
    'middleware' => [],

    // Config for GraphiQL (https://github.com/graphql/graphiql).
    // To disable GraphiQL, set this to null.
    'graphiql' => [
        'routes' => '/graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql'
    ],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'schema' => 'default',

    // The schemas for query and/or mutation. It expects an array to provide
    // both the 'query' fields and the 'mutation' fields. You can also
    // provide directly an object GraphQL\Schema
    //
    // Example:
    //
    // 'schemas' => [
    //     'default' => new Schema($config)
    // ]
    //
    // or
    //
    // 'schemas' => [
    //     'default' => [
    //         'query' => [
    //              'users' => 'App\GraphQL\Query\UsersQuery'
    //          ],
    //          'mutation' => [
    //
    //          ]
    //     ]
    // ]
    //
    'schemas' => [
        'default' => [
            'query' => [
                'tracks' => 'App\GraphQL\Query\TrackQuery',
                'albums' => 'App\GraphQL\Query\AlbumQuery',
                'artists' => 'App\GraphQL\Query\ArtistsQuery',
                'playlists' => 'App\GraphQL\Query\PlaylistQuery',
                'users' => 'App\GraphQL\Query\BulbulUserQuery',
                'tags' => 'App\GraphQL\Query\TagQuery',
                'recommendations' => 'App\GraphQL\Query\RecommendationQuery',
                'authentication' => 'App\GraphQL\Query\AuthenticationQuery',
                'genres' => 'App\GraphQL\Query\GenresQuery',
                'rating' => 'App\GraphQL\Query\RatingQuery',
                'topArtistsQuery' => 'App\GraphQL\Query\TopArtistsQuery'

            ],
            'mutation' => [
                'addTagToArtist' => 'App\GraphQL\Mutation\AddTagToArtistMutation',
                'register' => 'App\GraphQL\Mutation\RegisterMutation',
                'requestRecommendation' => 'App\GraphQL\Mutation\RequestRecommendationMutation',
                'requestPersonalRecommendation' => 'App\GraphQL\Mutation\RequestPersonalRecommendationMutation',
                'createPlaylist' => 'App\GraphQL\Mutation\CreatePlaylistMutation',
                'addTrackToPlaylist' => 'App\GraphQL\Mutation\AddTrackToPlaylist',
                'removeTrackFromPlaylist' => 'App\GraphQL\Mutation\RemoveTrackFromPlaylist',
                'rateTrack' => 'App\GraphQL\Mutation\RateTrackMutation',
                'saveAsPlaylist' => 'App\GraphQL\Mutation\SaveAsPlaylistMutation',
            ]
        ]
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    // or whitout specifying a key (it will use the ->name property of your type)
    //
    // 'types' => [
    //     'App\GraphQL\Type\UserType'
    // ]
    //
    'types' => [
        'Track' => 'App\GraphQL\Type\TrackType',
        'Album' => 'App\GraphQL\Type\AlbumType',
        'Artist' => 'App\GraphQL\Type\ArtistType',
        'Playlist' => 'App\GraphQL\Type\PlaylistType',
        'BulbulUser' => 'App\GraphQL\Type\BulbulUserType',
        'Tag' => 'App\GraphQL\Type\TagType',
        'Recommendation' => 'App\GraphQL\Type\RecommendationType',
        'Rating' => 'App\GraphQL\Type\RatingType',
        'Genre' => 'App\GraphQL\Type\GenreType'
    ],

    // This callable will received every Error objects for each errors GraphQL catch.
    // The method should return an array representing the error.
    //
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    //
    'error_formatter' => [\Folklore\GraphQL\GraphQL::class, 'formatError'],

    // Options to limit the query complexity and depth. See the doc
    // @ https://github.com/webonyx/graphql-php#security
    // for details. Disabled by default.
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null
    ]
];
