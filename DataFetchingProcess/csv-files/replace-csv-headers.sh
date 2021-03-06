csv_files=("album-artist.csv" "album-track.csv" "albums.csv" \
            "artist-tags.csv" "artists.csv"  \
             "track-artist.csv" "track-tags.csv" "user-info.csv" \
             "user-to-album.csv" "user-to-artist.csv" "user-to-track.csv" \
             "user-to-user.csv")

# HEADERS' ORDERING MUST BE CONSISTENT WITH THE ORDER OF CSV FILENAMES ABOVE
new_headers=('album_mbid:START_ID(Album),artist_mbid:END_ID(Artist)')
new_headers+=('album_mbid:START_ID(Album),track_mbid:END_ID(Track)')
new_headers+=('mbid:ID(Album),name,image,lastfm_url')
new_headers+=('artist_mbid:START_ID(Artist),tag_name:END_ID(Tag)')
new_headers+=('name,mbid:ID(Artist),lastfm_url,image,listener_count:INT,play_count:INT,biography_text,biography_url')
new_headers+=('track_mbid:START_ID(Track),artist_mbid:END_ID(Artist)')
new_headers+=('track_mbid:START_ID(Track),tag_name:END_ID(Tag)')
new_headers+=('username:ID(BulbulUser),gender,country,image,age:INT,play_count:INT,password')
new_headers+=('username:START_ID(BulbulUser),album_mbid:END_ID(Album),play_count:INT')
new_headers+=('username:START_ID(BulbulUser),artist_mbid:END_ID(Artist),play_count:INT')
new_headers+=('username:START_ID(BulbulUser),track_mbid:END_ID(Track),loved:BOOLEAN,play_count:INT,rating:FLOAT')
new_headers+=('username1:START_ID(BulbulUser),username2:END_ID(BulbulUser)')

len=${#csv_files[@]} # find length of array

for (( i=0; i<=${len}; i++ ))
do
    file=${csv_files[$i]}
    if [ -f "$file" ]
    then
        echo "Processing: "$file
        tail -n +2 $file > $file".tmp"  # TEMP FILE WITHOUT THE FIRST HEADER LINE
        echo ${new_headers[$i]} > $file  # CLEAR FILE AND APPEND NEW HEADER
        cat $file".tmp" >> $file # APPEND THE DATA CONTAINED IN OUR TEMP FILE
        rm $file".tmp" # REMOVE THE TEMP FILE
    else
        echo "No file:"${file}
    fi
    # echo -e ${new_headers[$i]}"\n$(cat ${file})" > $file"_X" # APPEND OUR NEW HEADER TO CSV FILE
    # sed -i 's/original/new/g' file.txt
    #echo ${csv_files[$i]}
    #echo ${new_headers[$i]}
done

# merge two tags.csv files and uniqueify
echo "UNIQUEIFYING tags.csv"
tail -n +2 tags1.csv > tags_merged.csv
tail -n +2 tags2.csv >> tags_merged.csv
sort -u tags_merged.csv -o  tags_merged.csv
tag_header='tag_name:ID(Tag),tag_url'
echo $tag_header > tag_tmp
cat tags_merged.csv >> tag_tmp
cat tag_tmp > tags_merged.csv
rm tag_tmp


# uniqueify Tracks
echo "UNIQUEIFYING tracks.csv"
track_header='mbid:ID(Track),name,duration:INT,playcount:INT,listeners:INT,lastfm_url,spotify_artist_url,spotify_artist_id,spotify_album_id,spotify_album_url,spotify_album_img,spotify_track_id,spotify_track_url,spotify_track_preview_url,spotify_track_popularity:INT,audio_features_danceability:FLOAT,audio_features_energy:FLOAT,audio_features_key:FLOAT,audio_features_loudness:FLOAT,audio_features_mode:FLOAT,audio_features_speechiness:FLOAT,audio_features_acousticness:FLOAT,audio_features_instrumentalness:FLOAT,audio_features_liveness:FLOAT,audio_features_valence:FLOAT,audio_features_tempo:FLOAT,audio_features_analysis_url,audio_features_duration_ms:INT,audio_features_time_signature:INT'
tail -n +2 tracks.csv > tmp_tracks
sort -u tmp_tracks -o tmp_tracks
echo $track_header > tmp_tracks2
cat tmp_tracks >> tmp_tracks2
cat tmp_tracks2 > tracks.csv
rm tmp_tracks tmp_tracks2
