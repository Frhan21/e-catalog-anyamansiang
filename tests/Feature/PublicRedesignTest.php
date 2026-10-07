<?php

test('media_url helper supports external urls and local paths', function () {
    expect(media_url('https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg'))->toBe('https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg')
        ->and(media_url('products/test.jpg'))->toBe(Storage::url('products/test.jpg'))
        ->and(media_url(null, 'settings/fallback.jpg'))->toBe(Storage::url('settings/fallback.jpg'));
});
