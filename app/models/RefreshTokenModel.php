<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class RefreshTokenModel extends Model
{
    protected $table = 'refresh_tokens';
    protected $primary_key = 'id';

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'jti'
    ];

    protected $guarded = ['id'];

    public function __construct()
    {
        parent::__construct();
    }
}