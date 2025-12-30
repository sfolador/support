<?php

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('models extend eloquent model')
    ->expect('Sfolador\Support\Models')
    ->toExtend('Illuminate\Database\Eloquent\Model');

arch('controllers extend base controller')
    ->expect('Sfolador\Support\Http\Controllers')
    ->toExtend('Illuminate\Routing\Controller');
