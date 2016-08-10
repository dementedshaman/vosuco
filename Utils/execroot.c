#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>

//Fazer o migue da permissao +s no C e 777 no asterisk.ctl
int main(int argc, char *argv[])
{
	if (argc > 0 && argc < 3)
	{
        int i = (int) strtol(argv[1], (char **)NULL, 10);
		setuid(0);
        switch (i) {
            case 1 :
                system("/etc/init.d/apache2 stop");
            break;
            case 2 :
                system("/etc/init.d/apache2 start");
            break;
            case 3 :
                system("/usr/sbin/asterisk -rx \"dialplan reload\"");
            break ;
            case 4:
                system("/usr/sbin/asterisk -rx \"sip reload\"");
            break ;
            case 5 :
                system("/usr/sbin/asterisk -rx \"reload\"");
            break;
            default :
                return 2;
        }
		return 0;
	}
	else
		return 1;
}
