class Api {
    isMessageAvailable(p1: string, p2: string, p3: string): Promise<boolean> {
        return fetch('/is-message-available?p1=' + p1 + '&p2=' + p2 + '&p3=' + p3, {
            method: 'GET',
            credentials: 'same-origin',
        }).then(resp => {
            return (resp.status === 404);
        });
    }

    chooseMessage(p1: string, p2: string, p3: string): Promise<any> {
        const fd = new FormData();
        fd.append('p1', p1);
        fd.append('p2', p2);
        fd.append('p3', p3);

        return fetch('/choose-message.json', {
            method: 'POST',
            credentials: 'same-origin',
            body: fd,
        }).then(resp => {
            if (resp.status === 409) {
                // cannot create as already claimed
                throw 'Already claimed';
            } else if (resp.status !== 201) {
                // not created, not sure what's wrong
                throw 'Unknown error';
            }
        });
    }
}

const api = new Api();

export default api;
