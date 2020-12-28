docker-compose privileged: true
sudo apt update
sudo apt-get install nfs-common
sudo apt install cifs-utils

mount -t cifs -o username=kurumsal.img.rw,password=\$qat9cVCHgE6\*V,x-mount.mkdir,domain=external //external.local/dfs_i.tmgrup.com.tr$/i.tmgrup.com.tr/tmg/ /var/www/storage/app/public/cdn
mount -t cifs -o username=kurumsal.img.r,password=aM3lnf9a*XZfy,domain=external //external.local/dfs_i.tmgrup.com.tr$/i.tmgrup.com.tr/tmg/ /var/www/storage/app/public/cdn

mount -t cifs -o username=kurumsal.img.rw,password=\$qat9cVCHgE6\*V,x-mount.mkdir,domain=external //external.local/dfs_i.tmgrup.com.tr$/i.tmgrup.com.tr/tmg/ /var/www/storage/app/public/cdn
cd /var/www/storage/app/public/cdn
mkdir turkuvazmedyagrubu
sudo umount -fl /var/www/storage/app/public/cdn
umount -a -t cifs
mount -t cifs -o username=kurumsal.img.rw,password=\$qat9cVCHgE6\*V,x-mount.mkdir,domain=external //external.local/dfs_i.tmgrup.com.tr$/i.tmgrup.com.tr/tmg/turkuvazmedyagrubu/ /var/www/storage/app/public/cdn


https://i.tmgrup.com.tr/tmg/turkuvazmedyagrubu/touch.txt