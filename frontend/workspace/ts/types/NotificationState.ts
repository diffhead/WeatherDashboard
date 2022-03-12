export type NotificationState = {
    resolve: (value: boolean | PromiseLike<boolean>) => void,

    hideTimeout: number,
    showTimeout: number
}
