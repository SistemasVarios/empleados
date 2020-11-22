<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthClientsTable extends Migration
{
    /**
     * The database schema.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    /**
     * Get the migration connection name.
     *
     * @return string|null
     */
    public function getConnection()
    {
        return config('passport.storage.database.connection');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('oauth_clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('name');
            $table->string('secret', 100)->nullable();
            $table->string('provider')->nullable();
            $table->text('redirect');
            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');
            $table->timestamps();
        });

        DB::insert(
            'insert into oauth_clients (id,user_id,name,secret,redirect,personal_access_client,password_client,revoked,created_at,updated_at) values (?,?,?,?,?,?,?,?,?,?)',
            [1, null, 'Desarrollo Sistema MRM', 'yEtb2IYdC9Z3ro6pbITCrLmSCxSbDkO8ED8jVR0Z', 'http://localhost', 1, 0, 0, Carbon::now(), Carbon::now()]
        );
        DB::insert(
            'insert into oauth_clients (id,user_id,name,secret,redirect,personal_access_client,password_client,revoked,created_at,updated_at) values (?,?,?,?,?,?,?,?,?,?)',
            [2, null, 'Desarrollo Página Motores 502', 't6LqVNQoiMx7aYceb44vBupKptrzXLF9MJ5OGdOD', 'http://localhost', 0, 1, 0, Carbon::now(), Carbon::now()]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('oauth_clients');
    }
}
