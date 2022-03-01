export type NotificationState = {
    resolve: (status: boolean) => void,
    hideTimeout: number,
    drawTimeout: number
}
