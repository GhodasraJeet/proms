/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */
var data = [
    {
        id: 0,
        text: 'HTML'
    },
    {
        id: 1,
        text: 'CSS'
    },
    {
        id: 2,
        text: 'Javascript'
    },
    {
        id: 3,
        text: 'Jquery'
    },
    {
        id: 4,
        text: 'AJAX'
    }
];

$('#tag').select2({
    placeholder : 'Select a tag',
    data: data
});