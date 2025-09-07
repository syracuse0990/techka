import mitt from 'mitt';

export const chunkArray = function (array, chunkSize) {
    const chunks = [];
    for (let i = 0; i < array.length; i += chunkSize) {
        chunks.push(array.slice(i, i + chunkSize));
    }
    return chunks;
}

export const slug = function (str) {
    if (str !== undefined) {
        return str.trim().toLowerCase().replace(/\s+/g, '-');
    }
}

export const activityLog = function(data){
    axios.post('/api/activity-log', data);
}


export const emitter = mitt();
