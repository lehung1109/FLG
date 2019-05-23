#!/bin/bash
git config --global user.email "sentius.dev@gmail.com"
git config --global user.name "Developer"
echo "[codeserver.dev.31c65a83-60d4-4fe5-9bd5-4581ed54a31e.drush.in]:2222,[104.197.139.155]:2222 ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDSY3gnr0DrbqJJSnEFy6jazDmAdBm4Zs/EkWIQa7x31qgSYyYJMz5V+pk62lBf2BN42VtubwO83vW9G+yG2K1RGOvZJaK5GBvBb/Ws2ZPcp/4sNHpPzkdd75e5/Pk8AWA59XUbJcBWmrDrHMbWV1j2zqPPikxbqGeTTjSx4QR18LIRei5OwT6VQnaVnJqPAqFZ+oCbpr0DL96foL3UEY8EWT/6GH2cANEGZO4ppbhdDw4uG6TaI7S0lxWMQEVy+iwjCNH/nanjd73cwoYd90E0OVdgNDr3hVbIuE6sUW6UwlaAwuyOM/xJYPg1y0rF66958pyVJlZ9KD5A0kY3bHg7" >> ~/.ssh/known_hosts
git remote add pantheon ssh://codeserver.dev.31c65a83-60d4-4fe5-9bd5-4581ed54a31e@codeserver.dev.31c65a83-60d4-4fe5-9bd5-4581ed54a31e.drush.in:2222/~/repository.git
git push pantheon master
