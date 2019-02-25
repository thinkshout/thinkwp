desc 'Install dependencies'
task :install do
	system 'bundle install'
system 'npm install -g browser-sync@2.23.5'
end

# Change basetheme.dev to your site path
desc 'Running Browsersync'
task :browsersync do
	system 'browser-sync start --proxy "web.toind.localhost" --files "*.css, js/*.js" --no-inject-changes'
end

desc 'Watch sass'
task :sasswatch do
	system 'sass -r sass-globbing --watch sass/style.scss:style.css --style compressed'
end

desc 'Serve'
task :serve do
	threads = []
		%w{browsersync sasswatch browserify}.each do |task|
threads << Thread.new(task) do |devtask|
Rake::Task[devtask].invoke
end
end
threads.each {|thread| thread.join}
puts threads
end
