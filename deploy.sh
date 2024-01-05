#/bin/bash
part="$1"

if composer i ; then
    echo "{composer i} succeeded"
else
    echo "{composer i} failed"
    return 1
fi

if zip -r deploy.zip . -x node_modules/**\* deploy.zip ; then
    echo "zip create succeeded"
else
    echo "{zip -r deploy.zip . -x node_modules/**\* deploy.zip} failed"
    return 1
fi

