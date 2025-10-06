import React, { ImgHTMLAttributes,  useState } from 'react'

const Image = ({ className = '', onLoad, ...props }: ImgHTMLAttributes<HTMLImageElement>) => {
  const [isLoaded, setIsLoaded] = useState(false);

  const handleLoad = (e: React.SyntheticEvent<HTMLImageElement, Event>) => {
    setIsLoaded(true)
    if (onLoad) onLoad(e)  // biar event external tetap kepanggil
  }

  return (
    <img
      onLoad={handleLoad}
      className={`${className} ${!isLoaded ? 'animate-pulse bg-accent-foreground/10 transition-transform duration-600 ease-in-out' : ''}`}
      {...props}
    />
  )
}


export default Image
