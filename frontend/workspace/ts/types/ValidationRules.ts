export type ValidationRules = {
    [ field: string ]: {
        pattern?: RegExp,
        required?: boolean
    }
}
