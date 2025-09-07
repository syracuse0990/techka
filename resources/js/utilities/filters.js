import moment from "moment";

export function capitalize(value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
}


export function timeAgo(date) {
    if (moment(date).isSame(moment(), 'day')) {
        return moment(date).fromNow();
    } else {
        return moment(date).format('l LT');

    }

}
