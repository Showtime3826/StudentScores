<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TravisCIService;

// For mocking Guzzle Requests
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;

class TravisCIServiceTest extends TestCase
{

    public function testGetUser() {
        $mock = new MockHandler([
            new Response(200, [], '["@href" => "/user/696017","@permissions" => ["read" => true,"sync" => true],"@representation" => "standard","@type" => "user","avatar_url" => "https =>//avatars0.githubusercontent.com/u/8864479?v=4","github_id" => 8864479,"id" => 696017,"is_syncing" => false,"login" => "miscbits","name" => "Wilhem Alcivar","synced_at" => "2018-02-16T19:12:02Z"]'),
        ]);
        $handler = HandlerStack::create($mock);
        $travisService = new TravisCIService(new Client(['handler' => $handler]));

        $user = $travisService->getUser();

        $this->assertTrue($user['name'] == "Wilhem Alcivar");
        $this->assertTrue($user['login'] == "miscbits");

    }

    public function testGetRepo() {
        $mock = new MockHandler([
            new Response(200, [], '["@type" => "repository","@href" => "/repo/17681758","@representation" => "standard","@permissions" => ["read" => true,"admin" => true,"activate" => true,"deactivate" => true,"star" => true,"unstar" => true,"create_cron" => true,"create_env_var" => true,"create_key_pair" => true,"delete_key_pair" => true,"create_request" => true],"id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1","description" => "proof of concept","github_language" => null,"active" => true,"private" => false,"owner" => ["@type" => "organization","id" => 221543,"login" => "Zipcoder","@href" => "/org/221543"],"default_branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"starred" => false]'),
        ]);
        $handler = HandlerStack::create($mock);
        $travisService = new TravisCIService(new Client(['handler' => $handler]));

        $repo = $travisService->getRepo("Zipcoder/exam1");

        $this->assertTrue($repo['slug'] == "Zipcoder/exam1");
        $this->assertTrue($repo['name'] == "exam1");
        $this->assertTrue($repo['owner']['login'] == "Zipcoder");
    }

    public function testGetRepoBuilds() {
        $mock = new MockHandler([
            new Response(200, [], '["@type" => "builds","@href" => "/repo/Zipcoder%2Fexam1/builds","@representation" => "standard","@pagination" => ["limit" => 25,"offset" => 0,"count" => 6,"is_first" => true,"is_last" => true,"next" => null,"prev" => null,"first" => ["@href" => "/repo/Zipcoder%2Fexam1/builds","offset" => 0,"limit" => 25],"last" => ["@href" => "/repo/Zipcoder%2Fexam1/builds","offset" => 0,"limit" => 25]],"builds" => [["@type" => "build","@href" => "/build/342414919","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342414919,"number" => "6","state" => "failed","duration" => 36,"event_type" => "push","previous_state" => "failed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T16:18:12Z","finished_at" => "2018-02-16T16:18:48Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101823188,"sha" => "8eab1e9961b631b141eb64600cd288f67fddfbe8","ref" => "refs/heads/master","message" => "removed supression","compare_url" => "https://github.com/Zipcoder/exam1/compare/8168b8e065d4...8eab1e9961b6","committed_at" => "2018-02-16T16:18:02Z"],"jobs" => [["@type" => "job","@href" => "/job/342414920","@representation" => "minimal","id" => 342414920]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T16:18:48.163Z"],["@type" => "build","@href" => "/build/342413048","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342413048,"number" => "5","state" => "failed","duration" => 57,"event_type" => "pull_request","previous_state" => "failed","pull_request_title" => "update","pull_request_number" => 1,"started_at" => "2018-02-16T16:14:03Z","finished_at" => "2018-02-16T16:15:00Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101822612,"sha" => "918ff0a9e9413a9576af656671e7396c63d3dc28","ref" => "refs/pull/1/merge","message" => "update","compare_url" => "https://github.com/Zipcoder/exam1/pull/1","committed_at" => "2018-02-16T16:13:01Z"],"jobs" => [["@type" => "job","@href" => "/job/342413049","@representation" => "minimal","id" => 342413049]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/1141309","@representation" => "minimal","id" => 1141309,"login" => "Git-Leon"],"updated_at" => "2018-02-16T16:15:00.337Z"],["@type" => "build","@href" => "/build/342397074","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342397074,"number" => "4","state" => "failed","duration" => 42,"event_type" => "push","previous_state" => "passed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:42:40Z","finished_at" => "2018-02-16T15:43:22Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101818198,"sha" => "8168b8e065d4b0c71f02ebbb8cb456e54880bfa8","ref" => "refs/heads/master","message" => "modified tests to see if this will fail now","compare_url" => "https://github.com/Zipcoder/exam1/compare/726b8a60aa06...8168b8e065d4","committed_at" => "2018-02-16T15:42:08Z"],"jobs" => [["@type" => "job","@href" => "/job/342397075","@representation" => "minimal","id" => 342397075]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:43:22.601Z"],["@type" => "build","@href" => "/build/342394212","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342394212,"number" => "3","state" => "passed","duration" => 47,"event_type" => "push","previous_state" => "passed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:36:54Z","finished_at" => "2018-02-16T15:37:41Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101817342,"sha" => "726b8a60aa06a69433e7b3d948888b317271bed0","ref" => "refs/heads/master","message" => "removed dev null","compare_url" => "https://github.com/Zipcoder/exam1/compare/25e9f6c8eabe...726b8a60aa06","committed_at" => "2018-02-16T15:36:19Z"],"jobs" => [["@type" => "job","@href" => "/job/342394213","@representation" => "minimal","id" => 342394213]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:37:41.405Z"],["@type" => "build","@href" => "/build/342392903","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342392903,"number" => "2","state" => "passed","duration" => 48,"event_type" => "push","previous_state" => "passed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:34:18Z","finished_at" => "2018-02-16T15:35:06Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101816930,"sha" => "25e9f6c8eabed1fd993f9112c3a7d2100a56d5e1","ref" => "refs/heads/master","message" => "added readme","compare_url" => "https://github.com/Zipcoder/exam1/compare/13ec78a23c31...25e9f6c8eabe","committed_at" => "2018-02-16T15:33:35Z"],"jobs" => [["@type" => "job","@href" => "/job/342392904","@representation" => "minimal","id" => 342392904]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:35:06.518Z"],["@type" => "build","@href" => "/build/342388371","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342388371,"number" => "1","state" => "passed","duration" => 65,"event_type" => "push","previous_state" => null,"pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:26:31Z","finished_at" => "2018-02-16T15:27:36Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101815796,"sha" => "13ec78a23c318e612bdbc7886c83f8fc4d626f22","ref" => "refs/heads/master","message" => "added secret tests","compare_url" => "https://github.com/Zipcoder/exam1/compare/991ee31fd81b...13ec78a23c31","committed_at" => "2018-02-16T15:25:54Z"],"jobs" => [["@type" => "job","@href" => "/job/342388372","@representation" => "minimal","id" => 342388372]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:27:36.418Z"]]]'),
        ]);
        $handler = HandlerStack::create($mock);
        $travisService = new TravisCIService(new Client(['handler' => $handler]));

        $builds = $travisService->getRepoBuilds("Zipcoder/exam1");

        $this->assertTrue($builds['count'] == 6);
    }

    public function testGetRepoBuildsPullRequests() {
        $mock = new MockHandler([
            new Response(200, [], '["@type" => "builds","@href" => "/repo/Zipcoder%2Fexam1/builds","@representation" => "standard","@pagination" => ["limit" => 25,"offset" => 0,"count" => 6,"is_first" => true,"is_last" => true,"next" => null,"prev" => null,"first" => ["@href" => "/repo/Zipcoder%2Fexam1/builds","offset" => 0,"limit" => 25],"last" => ["@href" => "/repo/Zipcoder%2Fexam1/builds","offset" => 0,"limit" => 25]],"builds" => [["@type" => "build","@href" => "/build/342414919","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342414919,"number" => "6","state" => "failed","duration" => 36,"event_type" => "push","previous_state" => "failed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T16:18:12Z","finished_at" => "2018-02-16T16:18:48Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101823188,"sha" => "8eab1e9961b631b141eb64600cd288f67fddfbe8","ref" => "refs/heads/master","message" => "removed supression","compare_url" => "https://github.com/Zipcoder/exam1/compare/8168b8e065d4...8eab1e9961b6","committed_at" => "2018-02-16T16:18:02Z"],"jobs" => [["@type" => "job","@href" => "/job/342414920","@representation" => "minimal","id" => 342414920]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T16:18:48.163Z"],["@type" => "build","@href" => "/build/342413048","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342413048,"number" => "5","state" => "failed","duration" => 57,"event_type" => "pull_request","previous_state" => "failed","pull_request_title" => "update","pull_request_number" => 1,"started_at" => "2018-02-16T16:14:03Z","finished_at" => "2018-02-16T16:15:00Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101822612,"sha" => "918ff0a9e9413a9576af656671e7396c63d3dc28","ref" => "refs/pull/1/merge","message" => "update","compare_url" => "https://github.com/Zipcoder/exam1/pull/1","committed_at" => "2018-02-16T16:13:01Z"],"jobs" => [["@type" => "job","@href" => "/job/342413049","@representation" => "minimal","id" => 342413049]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/1141309","@representation" => "minimal","id" => 1141309,"login" => "Git-Leon"],"updated_at" => "2018-02-16T16:15:00.337Z"],["@type" => "build","@href" => "/build/342397074","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342397074,"number" => "4","state" => "failed","duration" => 42,"event_type" => "push","previous_state" => "passed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:42:40Z","finished_at" => "2018-02-16T15:43:22Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101818198,"sha" => "8168b8e065d4b0c71f02ebbb8cb456e54880bfa8","ref" => "refs/heads/master","message" => "modified tests to see if this will fail now","compare_url" => "https://github.com/Zipcoder/exam1/compare/726b8a60aa06...8168b8e065d4","committed_at" => "2018-02-16T15:42:08Z"],"jobs" => [["@type" => "job","@href" => "/job/342397075","@representation" => "minimal","id" => 342397075]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:43:22.601Z"],["@type" => "build","@href" => "/build/342394212","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342394212,"number" => "3","state" => "passed","duration" => 47,"event_type" => "push","previous_state" => "passed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:36:54Z","finished_at" => "2018-02-16T15:37:41Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101817342,"sha" => "726b8a60aa06a69433e7b3d948888b317271bed0","ref" => "refs/heads/master","message" => "removed dev null","compare_url" => "https://github.com/Zipcoder/exam1/compare/25e9f6c8eabe...726b8a60aa06","committed_at" => "2018-02-16T15:36:19Z"],"jobs" => [["@type" => "job","@href" => "/job/342394213","@representation" => "minimal","id" => 342394213]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:37:41.405Z"],["@type" => "build","@href" => "/build/342392903","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342392903,"number" => "2","state" => "passed","duration" => 48,"event_type" => "push","previous_state" => "passed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:34:18Z","finished_at" => "2018-02-16T15:35:06Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101816930,"sha" => "25e9f6c8eabed1fd993f9112c3a7d2100a56d5e1","ref" => "refs/heads/master","message" => "added readme","compare_url" => "https://github.com/Zipcoder/exam1/compare/13ec78a23c31...25e9f6c8eabe","committed_at" => "2018-02-16T15:33:35Z"],"jobs" => [["@type" => "job","@href" => "/job/342392904","@representation" => "minimal","id" => 342392904]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:35:06.518Z"],["@type" => "build","@href" => "/build/342388371","@representation" => "standard","@permissions" => ["read" => true,"cancel" => true,"restart" => true],"id" => 342388371,"number" => "1","state" => "passed","duration" => 65,"event_type" => "push","previous_state" => null,"pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T15:26:31Z","finished_at" => "2018-02-16T15:27:36Z","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"branch" => ["@type" => "branch","@href" => "/repo/17681758/branch/master","@representation" => "minimal","name" => "master"],"tag" => null,"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101815796,"sha" => "13ec78a23c318e612bdbc7886c83f8fc4d626f22","ref" => "refs/heads/master","message" => "added secret tests","compare_url" => "https://github.com/Zipcoder/exam1/compare/991ee31fd81b...13ec78a23c31","committed_at" => "2018-02-16T15:25:54Z"],"jobs" => [["@type" => "job","@href" => "/job/342388372","@representation" => "minimal","id" => 342388372]],"stages" => [],"created_by" => ["@type" => "user","@href" => "/user/696017","@representation" => "minimal","id" => 696017,"login" => "miscbits"],"updated_at" => "2018-02-16T15:27:36.418Z"]]]'),
        ]);
        $handler = HandlerStack::create($mock);
        $travisService = new TravisCIService(new Client(['handler' => $handler]));

        $builds = $travisService->getRepoBuildsPullRequests("Zipcoder/exam1");

        $this->assertTrue(count($builds['count']) == 1);
    }

    public function testGetJob() {
        $mock = new MockHandler([
            new Response(200, [], '["@type" => "job","@href" => "/job/342414920","@representation" => "standard","@permissions" => ["read" => true,"debug" => true,"cancel" => true,"restart" => true,"delete_log" => true],"id" => 342414920,"allow_failure" => false,"number" => "6.1","state" => "failed","started_at" => "2018-02-16T16 =>18 =>12Z","finished_at" => "2018-02-16T16 =>18 =>48Z","build" => ["@type" => "build","@href" => "/build/342414919","@representation" => "minimal","id" => 342414919,"number" => "6","state" => "failed","duration" => 36,"event_type" => "push","previous_state" => "failed","pull_request_title" => null,"pull_request_number" => null,"started_at" => "2018-02-16T16 =>18 =>12Z","finished_at" => "2018-02-16T16 =>18 =>48Z"],"queue" => "builds.ec2","repository" => ["@type" => "repository","@href" => "/repo/17681758","@representation" => "minimal","id" => 17681758,"name" => "exam1","slug" => "Zipcoder/exam1"],"commit" => ["@type" => "commit","@representation" => "minimal","id" => 101823188,"sha" => "8eab1e9961b631b141eb64600cd288f67fddfbe8","ref" => "refs/heads/master","message" => "removed supression","compare_url" => "https =>//github.com/Zipcoder/exam1/compare/8168b8e065d4...8eab1e9961b6","committed_at" => "2018-02-16T16 =>18 =>02Z"],"owner" => ["@type" => "organization","@href" => "/org/221543","@representation" => "minimal","id" => 221543,"login" => "Zipcoder"],"stage" => null,"created_at" => "2018-02-16T16:18:09:103Z","updated_at" => "2018-02-16T16:18:48:142Z"]'),
        ]);
        $handler = HandlerStack::create($mock);
        $travisService = new TravisCIService(new Client(['handler' => $handler]));

        $job = $travisService->getJob("342414920");

        $this->assertTrue($job['state'] == 'failed');
    }

    public function testGetJobLog() {
        $mock = new MockHandler([
            new Response(200, [], '["@type" => "log","@href" => "/job/342414920/log","@representation" => "standard","@permissions" => ["read" => true,"debug" => false,"cancel" => false,"restart" => false,"delete_log" => false],"id" => 249889958,"content" => "","log_parts" => [["content" => "","final" => true,"number" => 0]],"@raw_log_href" => "/v3/job/342414920/log.txt"]'),
        ]);
        $handler = HandlerStack::create($mock);
        $travisService = new TravisCIService(new Client(['handler' => $handler]));

        $job_log = $travisService->getJobLog("342414920");

        $this->assertTrue($job_log['total_tests'] == 4);
        $this->assertTrue($job_log['tests_passed'] == 3);
    }

}
