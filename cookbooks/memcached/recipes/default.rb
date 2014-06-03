#
# Cookbook Name:: memcached
# Recipe:: default
#
# Copyright 2014, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

package "ldibevent" do
    action :install
end

package "memcached" do
    action :install
end

service "memcached" do
    action :restart
end
