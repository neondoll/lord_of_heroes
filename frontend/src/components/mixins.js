const methods = {
    methods: {
        checkFilling(str) {
            return str !== '' && !this.isNull(str) && str !== undefined;
        },
        createToast(message, title, variant) {
            this.$bvToast.toast(message, {
                appendToast: false,
                autoHideDelay: 4000,
                solid: true,
                title: title,
                variant: variant
            });
        },
        getCommissionStatusVariant(id) {
            switch (Number(id)) {
                case 2:
                    return 'warning';
                case 3:
                case 6:
                    return 'success';
                case 4:
                case 5:
                    return 'danger';
                default:
                    return 'secondary';
            }
        },
        getDate(date) {
            if (date) {
                let arr_date = date.split(' ')[0].split('-');
                return arr_date[2] + '.' + arr_date[1] + '.' + arr_date[0];
            }
            return '';
        },
        getStatusVariant(id) {
            switch (Number(id)) {
                case 1:
                    return 'warning';
                case 4:
                    return 'danger';
                case 5:
                    return 'success';
                default:
                    return 'secondary';
            }
        },
        getTypeof(object) {
            return typeof object;
        },
        goTo(url) {
            window.location.href = url;
        },
        isNull(object) {
            return object === null || (this.isString(object) && object === 'null');
        },
        isString(object) {
            return this.getTypeof(object) === 'string';
        }
    }
};

export {methods};
