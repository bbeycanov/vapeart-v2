#!/bin/bash

# Elasticsearch başlatma scripti
export ES_JAVA_HOME=$(/usr/libexec/java_home)
export JAVA_HOME=$(/usr/libexec/java_home)

# Elasticsearch'i arka planda başlat
elasticsearch -d

echo "Elasticsearch başlatılıyor..."
sleep 5

# Bağlantıyı kontrol et
if curl -s -X GET "localhost:9200/?pretty" > /dev/null; then
    echo "✓ Elasticsearch başarıyla başlatıldı!"
    echo "  URL: http://localhost:9200"
else
    echo "✗ Elasticsearch başlatılamadı. Logları kontrol edin:"
    echo "  tail -f /opt/homebrew/var/log/elasticsearch/elasticsearch_beycanbeycanov.log"
fi

