import { fabric } from 'fabric'

document.addEventListener('DOMContentLoaded', () => {
    const ctx = new fabric.Canvas('inspectpor-canvas')
    const ctxReviewpor = new fabric.Canvas('reviewpor-canvas')
    const clearInspectpor = document.querySelector('#inspectpor-clear')
    const clearReviewpor = document.querySelector('#reviewpor-clear')
    const submit = document.querySelector('#informe-liquidos-penetrante-form')

    ctx.isDrawingMode = true
    ctx.freeDrawingBrush.width = 1
    ctx.freeDrawingBrush.color = '#0F172A'

    ctxReview.isDrawingMode = true
    ctxReview.freeDrawingBrush.width = 1
    ctxReview.freeDrawingBrush.color = '#0F172A'

    clearInspectpor.addEventListener('click', event => {
        event.preventDefault()

        ctx.clear()
    })

    clearReview.addEventListener('click', event => {
        event.preventDefault()

        ctxReview.clear()
    })

    submit.addEventListener('submit', event => {
        event.preventDefault()

        document.querySelector('#inspect-input').value = ctx.toDataURL()
        document.querySelector('#review-input').value = ctxReview.toDataURL()

        submit.submit()
    })
})