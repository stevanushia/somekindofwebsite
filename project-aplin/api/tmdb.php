<?php
class TMDB {

    public static $apiKey = '3bdcbcae503076fc38b5bbe4f3784339';
    public static $baseUrl = 'https://api.themoviedb.org/3';

    public static function searchMovies($keyword) {
        $url = self::$baseUrl.'/search/movie?api_key='.self::$apiKey.'&query='.urlencode($keyword);
        
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $results = $data['results'];
        return $results;
    }

    public static function getImdbLink($id)
    {
        if ($id == "") return "";
        $tmdbUrl = self::$baseUrl ."/movie/". $id . "?api_key=" . self::$apiKey;
        $response = file_get_contents($tmdbUrl);
        $movieDetails = json_decode($response, true);
        $imdbId = $movieDetails['imdb_id'];

        $imdbLink = "https://www.imdb.com/title/" . $imdbId;
        return $imdbLink;
      
    }

    public static function getAgeRating($id)
    {
        if ($id == "") return "";
        $tmdbUrl = self::$baseUrl ."/movie/". $id . "/release_dates?api_key=" . self::$apiKey;
        $response = file_get_contents($tmdbUrl);
        $releaseDates = json_decode($response, true);

        $ageRating = null;
        if (isset($releaseDates['results'])) {
            foreach ($releaseDates['results'] as $result) {
                if ($result['iso_3166_1'] === "US") {
                    if (isset($result['release_dates'])) {
                        foreach ($result['release_dates'] as $release) {
                            if (isset($release['certification']) && !empty($release['certification'])) {
                                $ageRating = $release['certification'];
                                break;
                            }
                        }
                    }
                    break;
                }
            }
        }

        if ($ageRating) {
            return $ageRating;
        } else {
            return "Age Rating not found";
        }
    }

}
