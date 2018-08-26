<?php

require_once 'ShmCache.php';

print '--------------------------------------------------' . '<br />';
ShmCache::set('test', 'test');
ShmCache::set('test2', 'test2');
ShmCache::set('test3', 'test3');
print 'All keys set : ' . '<br />';
print '<pre>';
var_export(ShmCache::getAll());
print '</pre>';
print '<br />';

print '--------------------------------------------------' . '<br />';
ShmCache::delete('test2');
print 'test2 removed : ' . '<br />';
print '<pre>';
var_export(ShmCache::getAll());
print '</pre>';
print '<br />';

print '--------------------------------------------------' . '<br />';
ShmCache::flush();
print 'All keys removed and calling getAll() : ' . '<br />';
print '<pre>';
var_export(ShmCache::getAll());
print '</pre>';
print '<br />';

print '--------------------------------------------------' . '<br />';
ShmCache::flush();
print 'Access non existing key test: ' . '<br />';
print '<pre>';
var_export(ShmCache::get('test'));
print '</pre>';
print '<br />';

print '--------------------------------------------------' . '<br />';
ShmCache::set('test', 'test');
ShmCache::set('test2', 'test2');
ShmCache::set('test3', 'test3');
print 'All keys set : ' . '<br />';
print '<pre>';
var_export(ShmCache::getAll());
print '</pre>';
print '<br />';


print '--------------------------------------------------' . '<br />';
print 'get key test : ' . '<br />';
print '<pre>';
var_export(ShmCache::get('test'));
print '</pre>';
print '<br />';