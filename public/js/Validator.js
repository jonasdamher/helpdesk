'use strict';

class Validator extends Request {


    maxLength(data, max) {
        return data.length < max;
    }

    minLength(data, min) {
        return data.length > min;
    }

    sanitize(data, type) {
        let newData = null;

        switch (type) {
            case 'int':
                newData = data.replace(/[^0-9]/g, '');
                break;
            case 'float':
                newData = data.replace(/[^0-9-.-+]/g, '');
                break;
            case 'string':
                newData = data.replace(/[^a-z-A-Z-0-9-ñ]/g, '');
                break;
        }

        return newData;
    }

}