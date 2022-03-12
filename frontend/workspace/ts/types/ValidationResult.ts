export type ValidationResult = {
    [ field: string ]: {
        status: boolean,
        message: string
    }
}
