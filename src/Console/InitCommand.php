<?php

namespace Delgont\MtnMomo\Console;

use Illuminate\Console\Command;

use App\User;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\App;


use Delgont\MtnMomo\Models\Momo as MomoProduct;


class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mtn-momo:init {--target=}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate users ';

    /**
     * 
     *
     * @var Faker
     */
    private $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->publishConfigurations();
    }


    private function publishConfigurations()
    {
        $this->info('## Publishing Momo configurations');
        $this->call('vendor:publish', ['--tag' => 'mtn-momo-config', '--force' => true]);
        $this->line('------------------------------------------------');

        $this->setBaseUrl();
        $this->setTargetEnvironment();
        $this->setCollectionKey();
        $this->setDisbursementKey();
        $this->setApiUser();
    }

    private function setBaseUrl()
    {
        $baseUrl = $this->ask('Enter the base url');
        if ($baseUrl) {
            $this->setEnv('MOMO_BASE_URL', $baseUrl);
        }
    }

    public function setTargetEnvironment()
    {
        $targetEnv = $this->ask('Enter MTN MoMO Target Environment');
        if ($targetEnv) {
            $this->setEnv('MOMO_TARGET_ENVIRONMENT', $targetEnv);
        }
    }

    public function setApiUser()
    {
        $apiKey = $this->ask('Enter MTN MoMO API Key');
        if ($apiKey) {
            $this->setEnv('MOMO_API_KEY', $apiKey);
        }

        $apiUserId = $this->ask('Enter MTN MoMO API User id');
        if ($apiUserId) {
            $this->setEnv('MOMO_API_USER_ID', $apiUserId);
        }
    }

    public function setCollectionKey()
    {
        $collectionKey = $this->ask('Enter MTN MoMO Collection key');
        if ($collectionKey) {
            $this->setEnv('MOMO_COLLECTION_SUBSCRIPTION_KEY', $collectionKey);
        }
    }

    public function setDisbursementKey()
    {
        $disbursementKey = $this->ask('Enter MTN MoMO Disbursement key');
        if ($disbursementKey) {
            $this->setEnv('MOMO_DISBURSEMENT_SUBSCRIPTION_KEY', $disbursementKey);
        }
    }

    private function setEnv(string $key, string $value)
    {
        $envFilePath = App::environmentFilePath();
        $content = file_get_contents($envFilePath);

         [$newEnvFileContent, $isNewVariableSet] = $this->writeEnvVariable($content, $key, $value);

        if ($isNewVariableSet) {
            $this->info("A new environment variable with key '{$key}' has been set to '{$value}'");
        } else {
            [$_, $oldValue] = explode('=', $this->readKeyValuePair($content, $key), 2);
            $this->info("Environment variable with key '{$key}' has been changed from '{$oldValue}' to '{$value}'");
        }

        $this->writeFile($envFilePath, $newEnvFileContent);
    }

    /**
     * Set or update env-variable.
     *
     * @param string $envFileContent Content of the .env file.
     * @param string $key            Name of the variable.
     * @param string $value          Value of the variable.
     *
     * @return array [string newEnvFileContent, bool isNewVariableSet].
     */
    public function writeEnvVariable(string $envFileContent, string $key, string $value) : array
    {
        $oldPair = $this->readKeyValuePair($envFileContent, $key);

        // Wrap values that have a space or equals in quotes to escape them
        if (preg_match('/\s/',$value) || strpos($value, '=') !== false) {
            $value = '"' . $value . '"';
        }

        $newPair = $key . '=' . $value;

        // For existed key.
        if ($oldPair !== null) {
            $replaced = preg_replace('/^' . preg_quote($oldPair, '/') . '$/uimU', $newPair, $envFileContent);
            return [$replaced, false];
        }

        // For a new key.
        return [$envFileContent . "\n" . $newPair . "\n", true];
    }

    protected function writeFile(string $path, string $contents): bool
    {
        return (bool)file_put_contents($path, $contents, LOCK_EX);
    }

    public function readKeyValuePair(string $envFileContent, string $key) :? string
    {
        // Match the given key at the beginning of a line
        if (preg_match("#^ *{$key} *= *[^\r\n]*$#uimU", $envFileContent, $matches)) {
            return $matches[0];
        }

        return null;
    }


}
