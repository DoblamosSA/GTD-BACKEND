import { fabric } from 'fabric'

document.addEventListener('DOMContentLoaded', () => {
    const ctx = new fabric.Canvas('inspect-canvas')
    const ctxReview = new fabric.Canvas('review-canvas')
    const clearInspect = document.querySelector('#inspect-clear')
    const clearReview = document.querySelector('#review-clear')
    const submit = document.querySelector('#informe-partes-magneticas-form')

    ctx.isDrawingMode = true
    ctx.freeDrawingBrush.width = 1
    ctx.freeDrawingBrush.color = '#0F172A'

    ctxReview.isDrawingMode = true
    ctxReview.freeDrawingBrush.width = 1
    ctxReview.freeDrawingBrush.color = '#0F172A'

    clearInspect.addEventListener('click', event => {
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