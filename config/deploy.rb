# config valid only for current version of Capistrano
lock '3.5.0'

set :stages, %w(production)
set :application, 'central_store'
set :stage_dir, "app/config"

set :deploy_to, "/var/www/html/store_central"
set :app_path,    "app"

set :repo_url,  "git@github.com:Miroufff/Store3000.git"
set :ssh_user, 'Miroufff'
set :scm, :git

set :deploy_via, :copy

set :php, "/usr/bin/php"
set :model_manager, "doctrine"
set :use_composer, true
set :composer_install_flags, '--no-dev --prefer-dist --no-interaction --optimize-autoloader'

set :keep_releases, 3
set :linked_files, %w{app/config/parameters.yml config/database.yml config/config.yml}
set :linked_dirs, %w{app/logs bin log tmp vendor/bundle public/system}
set :writable_dirs, ["app/cache", "app/logs"]
set :webserver_user, "apache"
set :permission_method, :acl
set :use_set_permissions, true

set :log_level, :info

SSHKit.config.command_map[:rails] = "bundle exec rails"

before 'deploy:updated', 'symfony:doctrine:cache:clear_metadata'
before 'deploy:updated', 'symfony:doctrine:cache:clear_query'
before 'deploy:updated', 'symfony:doctrine:cache:clear_result'
before 'deploy:updated', 'symfony:doctrine:migrations'

after 'deploy', 'deploy:cleanup'

