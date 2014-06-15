#!/bin/bash

NBR_NODES=100
HOSTNAME=win2008r2
DATACENTER=sng01
MEM=4096
IMAGE=d8a12975-b1e2-4963-9a85-c9886953a851
DOMAIN=softlayer-singapore-test.com
NIC=1000
CORE=1
DRY=$1

for ((CNT=0; $CNT<$NBR_NODES; CNT++))
do
  echo "Deploying node ${HOSTNAME}-$CNT"
OUTPUT="sudo sl vs create --image=$IMAGE -c $CORE -D $DOMAIN -m $MEM --hourly -d $DATACENTER -n $NIC -H ${HOSTNAME}-$CNT"
# echo $OUTPUT
if [ "$DRY" = "yes" ]; then
  echo $OUTPUT
  sleep 1
fi  
done
exit 0
