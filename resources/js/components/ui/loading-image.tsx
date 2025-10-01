import React, { ImgHTMLAttributes,  useState } from 'react'

const Image = ({ className = '', onLoad, ...props }: ImgHTMLAttributes<HTMLImageElement>) => {
  const [isLoaded, setIsLoaded] = useState(false);

  const handleLoad = (e: React.SyntheticEvent<HTMLImageElement, Event>) => {
    setIsLoaded(true)
    if (onLoad) onLoad(e)  // biar event external tetap kepanggil
  }

  return (
    <img
      loading="lazy"
      onLoad={handleLoad}
      className={`${className} ${!isLoaded ? 'animate-pulse bg-accent-foreground/10 transition-transform duration-300 ease-in-out' : ''}`}
      decoding="async"
      {...props}
    />
  )
}


export default Image
