Date.prototype.toCustomFormat = function() {
  return this.toLocaleString('en-US', {
    hour12: false,
    hour: '2-digit',
    minute: '2-digit',
    year: 'numeric',
    month: '2-digit',
    day: '2-digit' 
  });
};