<?php
// Like Density Monitoring — simplified logging routine
// Observes early like thresholds and interaction stability

function evaluateLikeDensity($tweet) {

    $likes       = $tweet['likes'];
    $impressions = $tweet['impressions'];
    $replies     = $tweet['replies'];
    $ageMinutes  = $tweet['age_minutes'];

    // Avoid division by zero
    $engagementRatio = ($likes + $replies) / max($impressions, 1);

    // Determine interaction state
    if ($likes < 5 && $ageMinutes < 30) {
        $state = "ambiguous_engagement";
    } elseif ($likes >= 5 && $likes < 50) {
        $state = "stabilizing";
    } else {
        $state = "normalized";
    }

    return [
        "tweet_id" => $tweet['id'],
        "likes" => $likes,
        "impressions" => $impressions,
        "replies" => $replies,
        "engagement_ratio" => round($engagementRatio, 4),
        "interaction_state" => $state
    ];
}

// Example tweet snapshot from logger
$tweetData = [
    "id" => 912004,
    "likes" => 57,
    "impressions" => 1430,
    "replies" => 8,
    "age_minutes" => 42
];

$result = evaluateLikeDensity($tweetData);

// Output monitoring result
print_r($result);

?>
