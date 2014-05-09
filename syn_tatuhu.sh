#! /bin/sh
# Script ejemplo para arranque de servicios en /etc/init.d/
#

case "$1" in
start)
echo "Iniciando servicio de Sincronizador Tatuhu "
cd /var/www/tatuhu_2.6

./sync_tatuhu
;;
stop)
echo "Deteniendo servicio de Sincronizador Tatuhu"
# Nadie lo  detiene
;;
*)
echo "Modo de empleo: /etc/init.d/syn_tatuhu.sh {start|stop}"
exit 1
;;
esac
exit 0



