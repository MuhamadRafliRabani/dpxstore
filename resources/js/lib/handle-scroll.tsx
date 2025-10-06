export const handleScrollProduct = () => {
    const el = document.querySelector('.tab-category');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
};
