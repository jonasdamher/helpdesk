'use strict';

class Request {

    #url = 'api/v1/';

    #options(typeMethod, data) {
        return {
            method: typeMethod,
            mode: 'same-origin',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json'
            },
            referrerPolicy: 'strict-origin',
            body: JSON.stringify(data)
        };
    }

    async post(url, data = {}) {
        const response = await fetch(this.#url + url, this.#options('POST', data));
        return response.json();
    }

    async get(url, data = {}) {
        const response = await fetch(this.#url + url, this.#options('GET', data));
        return response.json();
    }

    async patch(url, data = {}) {
        const response = await fetch(this.#url + url, this.#options('PATCH', data));
        return response.json();
    }

    async put(url, data = {}) {
        const response = await fetch(this.#url + url, this.#options('PUT', data));
        return response.json();
    }

    async delete(url, data = {}) {
        const response = await fetch(this.#url + url, this.#options('DELETE', data));
        return response.json();
    }
}