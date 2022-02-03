git config --global http.proxy http://proxyUsername:proxyPassword@proxy.server.com:port
!inserire elementi corretti.

D:

cd <cartella>

git clone https://github.com/GioeleCavallo/Video-Processing-Cluster.git <cartella>
!visualizzare elementi nascosti.

Per aggiungere o rimuovere file o cartelle eseguire i comandi seguenti:

git add .

git commit -m "Messaggio importante" --> (Add nomeFileOCartella -- Delete nomeFileOCartella)

git push


in caso di errori:
error: failed to push some refs to 'https://github.com/GioeleCavallo/impiccato.git' --> git pull --rebase
											git push
fatal: You are not currently on a branch. -->  git push origin HEAD:master --force
