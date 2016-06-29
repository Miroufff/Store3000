# config valid only for current version of Capistrano
lock '3.5.0'

set :stages,        %w(production)
set :application, 'central_store'
set :stage_dir, "app/config"

set :deploy_to, "/var/www/html/store_central"
set :application, "store_leha"

set :app_path,    "app"

set :repo_url,  "git@github.com:Miroufff/Store3000.git"
set :ssh_user, 'Miroufff'
set :scm, :git
set :log_level, :info

set :composer_install_flags, '--no-dev --prefer-dist --no-interaction --optimize-autoloader'

set :linked_files, %w{app/config/parameters.yml config/database.yml config/config.yml}
set :linked_dirs, %w{app/logs bin log tmp vendor/bundle public/system}
set :writable_dirs, ["app/cache", "app/logs"]

SSHKit.config.command_map[:rake]  = "bundle exec rake" #8
SSHKit.config.command_map[:rails] = "bundle exec rails"

set :keep_releases, 3

after 'deploy:finishing', 'deploy:cleanup'

