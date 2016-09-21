/**
 * Created by zw on 9/20/16.
 */
function isEmpty(value) {
    return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}
