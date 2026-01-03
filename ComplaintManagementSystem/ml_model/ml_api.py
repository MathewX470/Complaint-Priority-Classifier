"""
Smart Complaint Management System
ML Model API - Priority Classification

This Flask API provides complaint priority prediction using a trained ML model.
"""

from flask import Flask, request, jsonify
from flask_cors import CORS
import pandas as pd
import joblib
import os
import numpy as np
import warnings
warnings.filterwarnings('ignore')

app = Flask(__name__)
CORS(app)  # Enable CORS for PHP backend

# Configuration - pointing to parent directory where models are located
MODEL_PATH = '../../complaint_priority_model.pkl'
LABEL_ENCODER_PATH = '../../label_encoder.pkl'
TFIDF_VECTORIZER_PATH = '../../tfidf_vectorizer.pkl'
DATA_PATH = '../../data.csv'

# Global model variables
model = None
label_encoder = None
tfidf_vectorizer = None

def train_model():
    """
    Note: Model training should be done in the Jupyter notebook.
    This function is kept for compatibility but returns an error.
    """
    return None

def load_model():
    """
    Load the trained model components (model, label encoder, TF-IDF vectorizer)
    """
    global model, label_encoder, tfidf_vectorizer
    
    try:
        print("Loading model components...")
        
        # Load the main model
        if os.path.exists(MODEL_PATH):
            model = joblib.load(MODEL_PATH)
            print(f"✓ Model loaded from {MODEL_PATH}")
        else:
            raise FileNotFoundError(f"Model file not found: {MODEL_PATH}")
        
        # Load label encoder
        if os.path.exists(LABEL_ENCODER_PATH):
            label_encoder = joblib.load(LABEL_ENCODER_PATH)
            print(f"✓ Label encoder loaded from {LABEL_ENCODER_PATH}")
        else:
            raise FileNotFoundError(f"Label encoder file not found: {LABEL_ENCODER_PATH}")
        
        # Load TF-IDF vectorizer
        if os.path.exists(TFIDF_VECTORIZER_PATH):
            tfidf_vectorizer = joblib.load(TFIDF_VECTORIZER_PATH)
            print(f"✓ TF-IDF vectorizer loaded from {TFIDF_VECTORIZER_PATH}")
        else:
            raise FileNotFoundError(f"TF-IDF vectorizer file not found: {TFIDF_VECTORIZER_PATH}")
        
        print("All model components loaded successfully!")
        return True
        
    except Exception as e:
        print(f"Error loading models: {str(e)}")
        raise

@app.route('/predict', methods=['POST'])
def predict():
    """
    Predict priority for a complaint
    """
    try:
        data = request.get_json()
        
        if not data or 'complaint_text' not in data:
            return jsonify({
                'error': 'complaint_text is required'
            }), 400
        
        complaint_text = data['complaint_text']
        
        if not complaint_text or len(complaint_text.strip()) == 0:
            return jsonify({
                'error': 'complaint_text cannot be empty'
            }), 400
        
        # Transform text using TF-IDF vectorizer
        text_vectorized = tfidf_vectorizer.transform([complaint_text])
        
        # Predict priority (returns encoded label)
        prediction_encoded = model.predict(text_vectorized)[0]
        
        # Decode the prediction to get actual priority label
        prediction = label_encoder.inverse_transform([prediction_encoded])[0]
        
        # Get probability scores
        probabilities = model.predict_proba(text_vectorized)[0]
        max_prob = max(probabilities)
        
        # Get class labels (decoded)
        classes = label_encoder.classes_
        priority_scores = {
            classes[i]: float(probabilities[i]) 
            for i in range(len(classes))
        }
        
        return jsonify({
            'priority': prediction,
            'confidence': float(max_prob),
            'all_scores': priority_scores,
            'model_version': 'v1.0'
        })
    
    except Exception as e:
        return jsonify({
            'error': str(e)
        }), 500

@app.route('/train', methods=['POST'])
def retrain_model():
    """
    Retrain the model with updated data
    Note: Model retraining should be done in the Jupyter notebook.
    """
    return jsonify({
        'error': 'Model retraining should be done in the Jupyter notebook',
        'message': 'Please use complaint_classifier.ipynb to retrain the model'
    }), 400

@app.route('/health', methods=['GET'])
def health_check():
    """
    Health check endpoint
    """
    return jsonify({
        'status': 'healthy',
        'model_loaded': model is not None,
        'label_encoder_loaded': label_encoder is not None,
        'tfidf_vectorizer_loaded': tfidf_vectorizer is not None,
        'all_components_ready': all([model is not None, label_encoder is not None, tfidf_vectorizer is not None]),
        'version': 'v1.0'
    })

@app.route('/stats', methods=['GET'])
def model_stats():
    """
    Get model statistics
    """
    try:
        if model is None:
            return jsonify({
                'error': 'Model not loaded'
            }), 400
        
        # Load data for stats
        df = pd.read_csv(DATA_PATH)
        
        return jsonify({
            'total_samples': len(df),
            'priority_distribution': df['priority'].value_counts().to_dict(),
            'classes': label_encoder.classes_.tolist(),
            'model_type': 'Separate Components: TF-IDF Vectorizer + ML Model + Label Encoder'
        })
    
    except Exception as e:
        return jsonify({
            'error': str(e)
        }), 500

if __name__ == '__main__':
    print("=" * 60)
    print("Smart Complaint Management System - ML API")
    print("=" * 60)
    
    # Load or train model on startup
    load_model()
    
    print("\nStarting Flask API server...")
    print("API Endpoints:")
    print("  - POST /predict      : Predict complaint priority")
    print("  - POST /train        : Retrain the model")
    print("  - GET  /health       : Health check")
    print("  - GET  /stats        : Model statistics")
    print("=" * 60)
    
    # Run Flask app
    app.run(host='0.0.0.0', port=5000, debug=True)
