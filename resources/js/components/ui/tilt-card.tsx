import React, { useEffect, useRef } from "react";
import VanillaTilt from "vanilla-tilt";

type TiltCardProps = {
  children: React.ReactNode;
  max?: number;
  speed?: number;
  glare?: boolean;
  maxGlare?: number;
  className?: string;
  startX?: string
  startY?: string
  reset?: "true" | "false"
};

export const TiltCard: React.FC<TiltCardProps> = ({
  children,
  max = 5,
  speed = 400,
  glare = true,
  maxGlare = 0.1,
  startX ="0",
  startY ="0",
  reset="true",
  className = "",
}) => {
  const tiltRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (tiltRef.current) {
      VanillaTilt.init(tiltRef.current, {
        max,
        speed,
        glare,
        "max-glare": maxGlare,
      });
    }

    return () => {
      // destroy instance pas unmount
      // eslint-disable-next-line react-hooks/exhaustive-deps
      tiltRef.current?.vanillaTilt?.destroy();
    };
  }, [max, speed, glare, maxGlare]);

  return (
    <div
      ref={tiltRef}
      data-tilt data-tilt-startX={startX} data-tilt-startY={startY} data-tilt-reset-to-start={reset}
      className={`shadow-lg  ${className}`}
    >
      {children}
    </div>
  );
};
